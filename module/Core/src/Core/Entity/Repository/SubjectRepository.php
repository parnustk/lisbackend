<?php

namespace Core\Entity\Repository;

use Core\Entity\Subject;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * @author sander
 */
class SubjectRepository extends EntityRepository  implements CRUD
{

    /**
     * 
     * @param type $params
     * @param type $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        if ($params) {
            //use if neccessary
        }

        $dql = "SELECT 
                    partial s.{id,code,name,durationAllAK,durationContactAK,durationIndependentAK},
                    partial module.{id,name},
                    partial gradingType.{id,gradingType}
                FROM Core\Entity\Subject s
                JOIN s.module module 
                JOIN s.gradingType gradingType";

        return new Paginator(
                new DoctrinePaginator(
                new ORMPaginator(
                $this->getEntityManager()
                        ->createQuery($dql)
                        ->setHydrationMode(Query::HYDRATE_ARRAY)
                )
                )
        );
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return Subject
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new Subject($this->getEntityManager());

        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        //manytomany validate manually
        if (!count($entity->getGradingType())) {
            throw new Exception(Json::encode('Missing gradingType', true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial s.{id,code,name,durationAllAK,durationContactAK,durationIndependentAK},
                        partial module.{id,name},
                        partial gradingType.{id,gradingType}
                    FROM Core\Entity\Subject s
                    JOIN s.module module 
                    JOIN s.gradingType gradingType
                    WHERE s.id = " . $entity->getId();

            try {
                $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
                $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }

            return $r;
        }
        return $entity;
    }
    
    /**
     * 
     * @param type $id
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            $dql = "
                    SELECT 
                        partial s.{id,code,name,durationAllAK,durationContactAK,durationIndependentAK},
                        partial module.{id,name},
                        partial gradingType.{id,gradingType}
                    FROM Core\Entity\Subject s
                    JOIN s.module module 
                    JOIN s.gradingType gradingType
                    WHERE s.id = " . $id;

            try {
                $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
                $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }

            return $r;
        }
        return $this->find($id);
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);
        $entity->setEntityManager($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "SELECT 
                        partial s.{id,code,name,durationAllAK,durationContactAK,durationIndependentAK},
                        partial module.{id,name},
                        partial gradingType.{id,gradingType}
                    FROM Core\Entity\Subject s
                    JOIN s.module module 
                    JOIN s.gradingType gradingType
                    WHERE s.id = " . $id;

            try {
                $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
                $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            } catch (Exception $exc) {
                throw new Exception($exc->getTraceAsString());
            }

            return $r;
        }
        return $entity;
    }
    
    /**
     * 
     * @param type $id
     * @param type $extra
     * @return type
     * @throws Exception
     */
    public function Delete($id, $extra = null)
    {
        try {
            $this->getEntityManager()->remove($this->find($id));
            $this->getEntityManager()->flush();
        } catch (Exception $exc) {
            throw new Exception($exc->getTraceAsString());
        }
        return $id;
    }

}

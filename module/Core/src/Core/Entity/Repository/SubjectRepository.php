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
class SubjectRepository extends EntityRepository
{

    /**
     * 
     * @param stdClass $params
     * @return Paginator
     */
    public function GetList($params = null)
    {
        if ($params) {
            //todo if neccessary
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
     * @param array $data
     * @param boolean $returnPartial
     * @return mixed
     * @throws Exception
     */
    public function Create($data, $returnPartial = false)
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

    public function Get($id, $returnPartial = false)
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
     * @return Sample
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false)
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

    public function Delete($id)
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

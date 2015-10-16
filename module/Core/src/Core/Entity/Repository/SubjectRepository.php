<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;
use Core\Entity\Subject;
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
                    WHERE s.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
//            print_r($data);
//            die('tere');
            return $r;
        }
        return $entity;
    }

    public function Get($id, $returnPartial = false)
    {
        if ($returnPartial) {

//            $dql = "
//                    SELECT 
//                        partial m.{id,name,duration,code},
//                        partial vocation.{id,name,code,durationEKAP},
//                        partial moduleType.{id,name},
//                        partial gradingType.{id,gradingType}
//                    FROM Core\Entity\Module m
//                    JOIN m.vocation vocation 
//                    JOIN m.moduleType moduleType
//                    JOIN m.gradingType gradingType 
//                    WHERE m.id = " . $id . "
//                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }
        return $this->find($id);
    }

    /**
     * 
     * @return Array
     */
    public function GetList($returnPartial = false)
    {
        if ($returnPartial) {

//            $dql = "
//                    SELECT 
//                        partial m.{id,name,duration,code},
//                        partial vocation.{id,name,code,durationEKAP},
//                        partial moduleType.{id,name},
//                        partial gradingType.{id,gradingType}
//                    FROM Core\Entity\Module m
//                    JOIN m.vocation vocation 
//                    JOIN m.moduleType moduleType
//                    JOIN m.gradingType gradingType
//                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }
        return $this->findAll();
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

//            $dql = "
//                    SELECT 
//                        partial m.{id,name,duration,code},
//                        partial vocation.{id,name,code,durationEKAP},
//                        partial moduleType.{id,name},
//                        partial gradingType.{id,gradingType}
//                    FROM Core\Entity\Module m
//                    JOIN m.vocation vocation 
//                    JOIN m.moduleType moduleType
//                    JOIN m.gradingType gradingType 
//                    WHERE m.id = " . $id . "
//                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

            return $r;
        }
        return $entity;
    }

    public function Delete($id)
    {
        $entity = $this->find($id);
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

}

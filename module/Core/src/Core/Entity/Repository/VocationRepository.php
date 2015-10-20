<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;
use Core\Entity\Vocation;
use Exception;
use Zend\Json\Json;

/**
 * @author sander
 */
class VocationRepository extends EntityRepository {

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function Create($data, $returnPartial = false) {
        $entity = new Vocation($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial v.{id,name,code,durationEKAP}
                    FROM Core\Entity\Vocation v
                    WHERE v.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }

    public function Get($id, $returnPartial = false) {
        if ($returnPartial) {
            $dql = "
                    SELECT 
                        partial v.{id,name, code, durationEKAP}
                    FROM Core\Entity\Vocation v
                    WHERE mt.id = " . $id;

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
    public function GetList($returnPartial = false) {
        if ($returnPartial) {
            $dql = "
                  
                    SELECT partial v.{id,name, code, durationEKAP}
                    FROM Core\Entity\Vocation v";
            $q = $this->getEntityManager()->createQuery($dql);
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
    public function Update($id, $data, $returnPartial = false) {
        $entity = $this->find($id);
        $entity->setEntityManager($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {
            $dql = "
                    SELECT 
                        partial v.{id,name, code, durationEKAP}
                    FROM Core\Entity\Vocation v
                    WHERE mt.id = " . $id;
            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }

    public function Delete($id) {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
        return $id;
    }

}

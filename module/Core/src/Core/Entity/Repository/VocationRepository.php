<?php

namespace Core\Entity\Repository;

use Core\Entity\Vocation;
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
class VocationRepository extends EntityRepository
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

        $dql = "SELECT partial v.{id,name, code, durationEKAP}
                FROM Core\Entity\Vocation v";

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

    public function Get($id, $returnPartial = false)
    {
        if ($returnPartial) {
            $dql = "
                    SELECT 
                        partial v.{id,name,code,durationEKAP}
                    FROM Core\Entity\Vocation v
                    WHERE v.id = " . $id;

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            return $q->getSingleResult(Query::HYDRATE_ARRAY);
        }
        return $this->find($id);
    }

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function Create($data, $returnPartial = false)
    {
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
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
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
            $dql = "
                    SELECT 
                        partial v.{id,name, code, durationEKAP}
                    FROM Core\Entity\Vocation v
                    WHERE v.id = " . $id;
            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }

    public function Delete($id)
    {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
        return $id;
    }

}

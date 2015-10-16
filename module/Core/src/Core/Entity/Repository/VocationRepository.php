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
class VocationRepository extends EntityRepository
{

    /**
     * 
     * @param array $data
     * @param type $params
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
            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }

    /**
     * 
     * @return Array
     */
    public function GetList()
    {
//        $dql = "SELECT partial s.{id,name} FROM Core\Entity\Sample s";
        $q = $this->getEntityManager()->createQuery($dql);
        $r = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $r;
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return Sample
     * @throws Exception
     */
    public function Update($id, $data)
    {

        $sample = $this->find($id);

        $sample->setEntityManager($this->getEntityManager());

        $sample->hydrate($data);

        if (!$sample->validate()) {
            throw new Exception(Json::encode($sample->getMessages(), true));
        }

        $this->getEntityManager()->persist($sample);
        $this->getEntityManager()->flush($sample);

        return $sample;
    }

}

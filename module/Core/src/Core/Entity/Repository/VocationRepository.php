<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;

//use Core\Entity\Sample;

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
    public function Create($data, $params = null)
    {
//        $sample = new Sample($this->getEntityManager());

        $sample->hydrate($data);

        if (!$sample->validate()) {
            throw new Exception(Json::encode($sample->getMessages(), true));
        }

        $this->getEntityManager()->persist($sample);
        $this->getEntityManager()->flush($sample);

        return $sample;
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

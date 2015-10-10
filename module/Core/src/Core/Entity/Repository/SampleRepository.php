<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;

//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;

use Core\Entity\Sample;

/**
 * @author sander
 */
class SampleRepository extends EntityRepository
{

    /**
     * 
     * @param array $data
     * @param type $params
     * @throws Exception
     */
    public function Create(array $data, $params = null)
    {
        $sample = new Sample($this->getEntityManager());
        
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
        $dql = "SELECT partial s.{id,name} FROM Core\Entity\Sample s";
        $q = $this->getEntityManager()->createQuery($dql);
        $r = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $r;
    }

}

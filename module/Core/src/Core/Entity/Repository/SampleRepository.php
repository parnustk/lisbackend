<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;

//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;

/**
 * @author sander
 */
class SampleRepository extends EntityRepository
{
    
    /**
     * 
     * @return Array
     */
    public function QuerySamples()
    {
        $dql = "SELECT partial s.{id,name} FROM Core\Entity\Sample s";
        $q = $this->getEntityManager()->createQuery($dql);
        $r = $q->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $r;
    }

}

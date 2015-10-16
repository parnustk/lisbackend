<?php

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;
use Core\Entity\GradingType;

/**
 * @author sander
 */
class GradingTypeRepository extends EntityRepository
{

    /**
     * 
     * @param array $data
     * @param boolean $returnPartial
     * @return GradingType
     * @throws Exception
     */
    public function Create($data, $returnPartial = false)
    {
        $entity = new GradingType($this->getEntityManager());

        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial gt.{id,name}
                    FROM Core\Entity\GradingType gt
                    WHERE gt.id = " . $entity->getId() . "
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
        $dql = "SELECT partial s.{id,gradingType} FROM Core\Entity\GradingType s";
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
        $entity = $this->find($id);
        $entity->setEntityManager($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        return $entity;
    }

    public function Delete($id)
    {
        $entity = $this->find($id);
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

}

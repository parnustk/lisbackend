<?php

namespace Core\Entity\Repository;

use Core\Entity\AbsenceReason;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * AbsenceReasonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbsenceReasonRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param type $params
     * @param type $extra
     */
    public function GetList($params = null, $extra = null)
    {
        ;//TODO
    }

    /**
     * 
     * @param type $id
     * @param type $returnPartial
     * @param type $extra
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
         if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial ar.{id,name}
                    FROM Core\Entity\AbsenceReason ar
                    WHERE ar.id = :id "
                ;//ar is alias

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $q->setParameter('id', $id);
            
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }
        return $this->find($id);
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        
        
        $entity = new AbsenceReason($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity); // teeb AB-i päringu, row is saved

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial ar.{id,name}
                    FROM Core\Entity\AbsenceReason ar
                    WHERE ar.id = " . $entity->getId() . "
                ";//ar is alias

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
     * @param type $returnPartial
     * @param type $extra
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

            $dql = "
                    SELECT 
                        partial ar.{id,name}
                    FROM Core\Entity\AbsenceReason ar
                    WHERE ar.id = :id "
                ;//ar is alias

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $q->setParameter('id', $id);
            
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }

    /**
     * 
     * @param type $id
     * @param type $extra
     */
    public function Delete($id, $extra = null)
    {
        $entity = $this->find($id);
        $entity->setTrashed(1);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $id;
    }

}

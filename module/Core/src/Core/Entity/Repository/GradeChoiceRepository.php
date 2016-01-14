<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Core\Entity\GradeChoice;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * GradeChoiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GradeChoiceRepository extends EntityRepository implements CRUD {

    /**
     * 
     * @param stdClass $params
     * @param mixed $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null) {
        if ($params) {
            //todo if neccessary
        }

        $dql = "SELECT partial gradechoice.{id,name}
                FROM Core\Entity\GradeChoice gradechoice";

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
     * @param int $id
     * @param bool $returnPartial
     * @param mixed $extra
     * @return int
     */
    public function Get($id, $returnPartial = false, $extra = null) {
        if ($returnPartial) {
            $dql = "
                    SELECT 
                    partial gradechoice.{id,name}
                    FROM Core\Entity\GradeChoice gradechoice
                    WHERE gradechoice.id = :id"; //gradechoice is alias

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
     * @return GradeChoice|array
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null) {
        //die("here repository");
        $entity = new GradeChoice($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity); // makes DB query, row is saved, id generated by mysql

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial gradechoice.{id,name}
                    FROM Core\Entity\GradeChoice gradechoice
                    WHERE gradechoice.id = " . $entity->getId();

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }

    /**
     * 
     * @param int $id
     * @param mixed $data
     * @param bool $returnPartial
     * @param mixed $extra
     * @return GradeChoice
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false, $extra = null) {
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
                        partial gradechoice.{id,name}
                    FROM Core\Entity\GradeChoice gradechoice
                    WHERE gradechoice.id = :id";
            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $q->setParameter('id', $id);

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }

    /**
     * 
     * @param int $id
     * @param mixed $extra
     * @return int
     */
    public function Delete($id, $extra = null) {
        //$entity = $this->find($id);
        //$entity->setTrashed(1);
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
        return $id;
    }

}

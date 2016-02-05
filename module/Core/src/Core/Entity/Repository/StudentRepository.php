<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * 
 */

namespace Core\Entity\Repository;

use Core\Entity\Student;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * Description of StudentRepository
 * 
 * @author Marten Kähr <marten@kahr.ee>
 */
class StudentRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new Student($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        try {
            
            $this->getEntityManager()->flush($entity);
            
        } catch (Exception $exc) {
            //this here does not work
            throw new Exception(Json::encode($exc->getMessage(), true));
            
        }

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial student.{
                            id,
                            firstName,
                            lastName,
                            code,
                            email
                        }
                    FROM Core\Entity\Student student
                    WHERE student.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }
    /**
     * 
     * @param int $id
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        if($returnPartial) {
            //generate dql
            $dql = "
                    SELECT 
                        partial student.{
                            id,
                            firstName,
                            lastName,
                            code,              
                            email
                        }
                    FROM Core\Entity\Student student
                    WHERE student.id = " . $id . "
                ";
            //return
            $q = $this->getEntityManager()->createQuery($dql);
//            print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }
        return $this->find($id);
    }

    /**
     * 
     * @param array|null $params
     * @param stdClass|null $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        if ($params) {
            //todo if neccessary
        }

        $dql = "SELECT 
                    partial student.{
                        id,
                        firstName,
                        lastName,
                        code,              
                        email
                    }
                FROM Core\Entity\Student student
                WHERE student.trashed IS NULL";

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
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     * @throws Exception
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
                        partial student.{
                            id,
                            firstName,
                            lastName,
                            code,              
                            email
                        }
                    FROM Core\Entity\Student student
                    WHERE student.id = " . $id;
            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }
    /**
     * 
     * @param int $id
     * @param type $extra
     * @return int
     */
    public function Delete($id, $extra = null)
    {
            $this->getEntityManager()->remove($this->find($id));
            $this->getEntityManager()->flush();
            return $id;
    }

}
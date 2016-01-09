<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Core\Entity\SubjectRound;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * SubjectRoundRepository
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class SubjectRoundRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param type $params
     * @param type $extra
     */
    public function GetList($params = null, $extra = null)
    {
        if ($params) {
            //todo if neccessary
        }

        $dql = "SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        }
                FROM Core\Entity\SubjectRound subjectRound
                JOIN subjectRound.subject subject
                JOIN subjectRound.studentGroup studentGroup
                WHERE subjectRound.trashed IS NULL";

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
     * @param type $id
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {

        if ($returnPartial) {

            $dql = "SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.subject subject
                    JOIN subjectRound.studentGroup studentGroup
                    WHERE subjectRound.id = :id"
            ;

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
     * @return SubjectRound
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new SubjectRound($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers', true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = " 
                    SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.subject subject
                    JOIN subjectRound.studentGroup studentGroup
                    WHERE subjectRound.id = " . $entity->getId() . "
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
        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers for subject round', true));
        }
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {
            $dql = " 
                    SELECT 
                        partial subjectRound.{
                            id
                        },
                        partial subject.{
                            id
                        },
                        partial studentGroup.{
                            id
                        },
                        partial teacher.{
                            id
                        }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.subject subject
                    JOIN subjectRound.studentGroup studentGroup
                    JOIN subjectRound.teacher teacher
                    WHERE subjectRound.id = :id"
            ;

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $q->setParameter('id', $id);

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);

            return $r;
        }
        return $entity;
    }

    /**
     * Delete by id
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

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
use Exception;

/**
 * Description of StudentRepository
 * 
 * @author Marten Kähr <marten@kahr.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'student';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\Student';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                        partial $this->baseAlias.{
                            id,
                            firstName,
                            lastName,
                            personalCode,
                            email,
                            trashed
                        }
                    FROM $this->baseEntity $this->baseAlias";
    }

    protected function dqlStudentStart()
    {
        return "SELECT 
                        partial $this->baseAlias.{
                            id,
                            firstName,
                            lastName,
                            personalCode,
                            email,
                            trashed
                        }
                    FROM $this->baseEntity $this->baseAlias";
    }

    protected function dqlTeacherStart()
    {
        return "SELECT 
                        partial $this->baseAlias.{
                            id,
                            firstName,
                            lastName,
                            personalCode,
                            email,
                            trashed
                        }
                    FROM $this->baseEntity $this->baseAlias";
    }

    protected function dqlAdministratorStart()
    {
        return "SELECT 
                        partial $this->baseAlias.{
                            id,
                            firstName,
                            lastName,
                            personalCode,
                            email,
                            trashed
                        }
                    FROM $this->baseEntity $this->baseAlias";
    }

     /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @return type
     */
    private function defaultCreate($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new Student($this->getEntityManager()), $data
        );
        return $this->singleResult($entity, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     */
    private function studentCreate($data, $returnPartial = false, $extra = null)
    {
        //TODO
        //set user related data
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    private function teacherCreate($data, $returnPartial = false, $extra = null)
    {
        //set user related data
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    private function administratorCreate($data, $returnPartial = false, $extra = null)
    {
        //TODO
        //set user related data
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        if (!$extra) {
            return $this->defaultCreate($data, $returnPartial);
        } else if ($extra->lisRole === 'student') {
            return $this->studentCreate($data, $returnPartial, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherCreate($data, $returnPartial, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorCreate($data, $returnPartial, $extra);
        }
    }

    /**
     * 
     * @param int $id
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    public function defaultGet($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            //generate dql
            $dql = "
                    SELECT 
                        partial student.{
                            id,
                            firstName,
                            lastName,
                            personalCode,              
                            email,
                            trashed
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
                        personalCode,              
                        email,
                        trashed
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
                            personalCode,              
                            email,
                            trashed
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

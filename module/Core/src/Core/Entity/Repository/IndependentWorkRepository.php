<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity\Repository;

use Core\Entity\IndependentWork;
use Exception;

/**
 * 
 * @author Kristen <seppkristen@gmail.com>
 * @author Alar Aasa <alar@alaraasa.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class IndependentWorkRepository extends AbstractBaseRepository
{

    /**
     * Using for dynamiq dql
     * protected type can be 
     * seeing in parent class also
     * @var string 
     */
    public $baseAlias = 'independentwork';

    /**
     *
     * @var string 
     */
    public $baseEntity = 'Core\Entity\IndependentWork';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        $dql = "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        duedate,
                        description,
                        durationAK,
                        trashed
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial teacher.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                LEFT JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.subjectRound subjectRound";

        return $dql;
    }

    /**
     * 
     * @return string
     */
    protected function dqlStudentStart()
    {
        $dql = "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        duedate,
                        description,
                        durationAK,
                        trashed
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial teacher.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound";

        return $dql;
    }

    /**
     * 
     * @return string
     */
    protected function dqlTeacherStart()
    {
        $dql = "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        duedate,
                        description,
                        durationAK,
                        trashed
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial studentGroup.{
                            id,
                            name
                    },
                    partial teacher.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound
                LEFT JOIN subjectRound.studentGroup studentGroup";

        return $dql;
    }

    /**
     * 
     * @return string
     */
    protected function dqlAdministratorStart()
    {
        $dql = "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        duedate,
                        description,
                        durationAK,
                        trashed
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial teacher.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound";

        return $dql;
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    private function defaultCreate($data, $returnPartial = false, $extra = null)
    {
        if (count($data) < 1) {
            throw new Exception('NO_DATA');
        }

        $entity = $this->validateEntity(
                new IndependentWork($this->getEntityManager()), $data
        );
        return $this->singleResult($entity, $returnPartial, $extra);
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    private function studentCreate($data, $returnPartial = false, $extra = null)
    {
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    private function teacherCreate($data, $returnPartial = false, $extra = null)
    {
        $data['createdBy'] = $extra->lisUser->getId();
        $data['teacher'] = $extra->lisPerson->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    private function administratorCreate($data, $returnPartial = false, $extra = null)
    {
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
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
     * @param type $entity
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    private function defaultUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $entityValidated = $this->validateEntity(
                $entity, $data
        );
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entityValidated, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    private function studentUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    private function teacherUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    private function administratorUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);
        if (!$entity) {
            throw new Exception('NOT_FOUND_ENTITY');
        }

        if (!$extra) {
            return $this->defaultUpdate($entity, $data, $returnPartial);
        } else if ($extra->lisRole === 'student') {
            return $this->studentUpdate($entity, $data, $returnPartial, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherUpdate($entity, $data, $returnPartial, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorUpdate($entity, $data, $returnPartial, $extra);
        }
    }

    /**
     * 
     * @param type $entity
     * @return type
     */
    private function defaultDelete($entity)
    {
        $id = $entity->getId();
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return $id;
    }

    private function studentDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }

    private function teacherDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }

    private function administratorDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }

    /**
     * Delete only trashed entities
     * 
     * @param int $id
     * @param stdClass|null $extra
     * @return int
     * @throws Exception
     */
    public function Delete($id, $extra = null)
    {
        $entity = $this->find($id);

        if (!$entity) {
            throw new Exception('NOT_FOUND_ENTITY');
        } else if (!$entity->getTrashed()) {
            throw new Exception('NOT_TRASHED');
        }

        if (!$extra) {
            return $this->defaultDelete($entity);
        } else if ($extra->lisRole === 'student') {
            return $this->studentDelete($entity, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherDelete($entity, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorDelete($entity, $extra);
        }
    }

    /**
     * 
     * @param int|string $id
     * @param bool $returnPartial
     * @param stdClass $extra
     * @return mixed
     */
    private function defaultGet($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            return $this->singlePartialById($id, $extra);
        }
        return $this->find($id);
    }

    /**
     * SELF RELATED RESTRICTION
     * 
     * @param type $entity
     * @param bool $returnPartial
     * @param stdClass $extra
     * @return array
     */
    private function studentGet($entity, $returnPartial = false, $extra = null)
    {

        if ($entity->getStudent() !== null) {
            if ($entity->getStudent()->getId() !== $extra->lisPerson->getId()) {
                throw new Exception('SELF_RELATED_RESTRICTION');
            }
        }

        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param bool $returnPartial
     * @param stdClass $extra
     * @return mixed
     */
    private function teacherGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param bool $returnPartial
     * @param stdClass $extra
     * @return mixed
     */
    private function administratorGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param int|string $id
     * @param bool $returnPartial
     * @param stdClass $extra
     * @return mixed
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);

        if (!$entity) {
            throw new Exception('NOT_FOUND_ENTITY');
        }

        if (!$extra) {
            return $this->defaultGet($id, $returnPartial, $extra);
        } else if ($extra->lisRole === 'student') {
            return $this->studentGet($entity, $returnPartial, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherGet($entity, $returnPartial, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorGet($entity, $returnPartial, $extra);
        }
    }

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     */
    private function defaultGetList($params = null, $extra = null, $dqlRestriction = null)
    {
        $dql = $this->dqlStart();
        $dql .= $this->dqlWhere($params, $extra);

        if ($dqlRestriction) {
            $dql .= $dqlRestriction;
        }
        return $this->wrapPaginator($dql);
    }

    /**
     * SELF RELATED RESTRICTION
     * 
     * @param array $params
     * @param stdClass|null $extra
     */
    private function studentGetList($params = null, $extra = null)
    {
        //$id = $extra->lisPerson->getId();
        //$dqlRestriction = " AND ($this->baseAlias.student=$id OR $this->baseAlias.student IS NULL) ";
        $dqlRestriction = null;
        return $this->defaultGetList($params, $extra, $dqlRestriction);
    }

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     */
    private function teacherGetList($params = null, $extra = null)
    {
        $id = $extra->lisPerson->getId();
        $dqlRestriction = " AND $this->baseAlias.teacher=$id";
        return $this->defaultGetList($params, $extra, $dqlRestriction);
    }

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     */
    private function administratorGetList($params = null, $extra = null)
    {
        return $this->defaultGetList($params, $extra);
    }

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        if (!$extra) {
            return $this->defaultGetList($params, $extra);
        } else if ($extra->lisRole === 'student') {
            return $this->studentGetList($params, $extra);
        } else if ($extra->lisRole === 'teacher') {
            return $this->teacherGetList($params, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorGetList($params, $extra);
        }
    }

}

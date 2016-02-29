<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity\Repository;

use Core\Entity\StudentGrade;
use Exception;

/**
 * Administrator ROLE
 * YES getList
 * YES get
 * 
 * Teacher ROLE
 * YES getList
 * YES get
 * YES create
 * YES update OWN CREATED
 * YES delete OWN CREATED
 * 
 * Student ROLE
 * YES getList - OWN RELATED
 * YES get - OWN RELATED
 * 
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentGradeRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'studentgrade';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\StudentGrade';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        notes,
                        trashed
                    },
                    partial student.{
                        id
                        },
                    partial contactlesson.{
                        id
                        },
                    partial gradeChoice.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial independentWork.{
                        id
                        },
                    partial module.{
                        id
                        },
                    partial subjectRound.{
                        id
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.student student
                JOIN $this->baseAlias.gradeChoice gradeChoice
                JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.contactLesson contactlesson
                LEFT JOIN $this->baseAlias.independentWork independentWork
                LEFT JOIN $this->baseAlias.module module
                LEFT JOIN $this->baseAlias.subjectRound subjectRound";
    }
    
    /**
     * 
     * @return string
     */
    protected function dqlStudentStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        notes,
                        trashed
                    },
                    partial student.{
                        id
                        },
                    partial contactlesson.{
                        id
                        },
                    partial gradeChoice.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial independentWork.{
                        id
                        },
                    partial module.{
                        id
                        },
                    partial subjectRound.{
                        id
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.student student
                JOIN $this->baseAlias.gradeChoice gradeChoice
                JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.contactLesson contactlesson
                LEFT JOIN $this->baseAlias.independentWork independentWork
                LEFT JOIN $this->baseAlias.module module
                LEFT JOIN $this->baseAlias.subjectRound subjectRound";
    }
    
    /**
     * 
     * @return string
     */
    protected function dqlTeacherStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        notes,
                        trashed
                    },
                    partial student.{
                        id
                        },
                    partial contactlesson.{
                        id
                        },
                    partial gradeChoice.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial independentWork.{
                        id
                        },
                    partial module.{
                        id
                        },
                    partial subjectRound.{
                        id
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.student student
                JOIN $this->baseAlias.gradeChoice gradeChoice
                JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.contactLesson contactlesson
                LEFT JOIN $this->baseAlias.independentWork independentWork
                LEFT JOIN $this->baseAlias.module module
                LEFT JOIN $this->baseAlias.subjectRound subjectRound";
    }
    
    /**
     * 
     * @return string
     */
    protected function dqlAdministratorStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        notes,
                        trashed
                    },
                    partial student.{
                        id
                        },
                    partial contactlesson.{
                        id
                        },
                    partial gradeChoice.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial independentWork.{
                        id
                        },
                    partial module.{
                        id
                        },
                    partial subjectRound.{
                        id
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.student student
                JOIN $this->baseAlias.gradeChoice gradeChoice
                JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.contactLesson contactlesson
                LEFT JOIN $this->baseAlias.independentWork independentWork
                LEFT JOIN $this->baseAlias.module module
                LEFT JOIN $this->baseAlias.subjectRound subjectRound";
    }

    /**
     * 
     * @param array $data
     * @return array
     */
    private function addMissingKeys($data)
    {
        if (!key_exists('contactLesson', $data)) {//validate that exactly one of four(contactLesson or module or subjectRound or independentWork) is present
            $data['contactLesson'] = null;
        }
        if (!key_exists('module', $data)) {
            $data['module'] = null;
        }
        if (!key_exists('subjectRound', $data)) {
            $data['subjectRound'] = null;
        }
        if (!key_exists('independentWork', $data)) {
            $data['independentWork'] = null;
        }
        return $data;
    }

    /**
     * 
     * @param array $data
     * @return boolean
     */
    private function validateInputRelationExists($data)
    {
        $Data = $this->addMissingKeys($data);
        $notValid = true;
        if ($Data['contactLesson'] && !$Data['module'] && !$Data['subjectRound'] && !$Data['independentWork']) {//validates
            $notValid = false;
        } else if (!$Data['contactLesson'] && $Data['module'] && !$Data['subjectRound'] && !$Data['independentWork']) {
            $notValid = false;
        } else if (!$Data['contactLesson'] && !$Data['module'] && $Data['subjectRound'] && !$Data['independentWork']) {
            $notValid = false;
        } else if (!$Data['contactLesson'] && !$Data['module'] && !$Data['subjectRound'] && $Data['independentWork']) {
            $notValid = false;
        }
        return $notValid;
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function defaultCreate($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new StudentGrade($this->getEntityManager()), $data
        );
        $notValid = $this->validateInputRelationExists($data);
        if ($notValid) {//if validates is still false throw exception
            throw new Exception('Missing or incorrect input');
        }
        return $this->singleResult($entity, $returnPartial, $extra);
    }

    /**
     * SELF CREATED RELATED RESTRICTION
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     */
    private function studentCreate($data, $returnPartial = false, $extra = null)
    {
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
            //TODO
        }
    }

    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function defaultUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $entityValidated = $this->validateEntity(
                $entity, $data
        );
        //validate that exactly one of four(contactLesson or module or subjectRound or independentWork) is present
        $notValid = $this->validateInputRelationExists($data);
        if ($notValid) {//if validates is still false throw exception
            throw new Exception('Missing or incorrect input');
        }

        return $this->singleResult($entityValidated, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
    private function studentUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function teacherUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        //TODO
        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    private function administratorUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        //TODO
        //set user related data
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
            //TODO
        } else if ($extra->lisRole === 'administrator') {
            //TODO
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

    /**
     * 
     * @param type $entity
     * @param type $extra
     */
    private function studentDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }

    private function teacherDelete($entity, $extra = null)
    {
        //TODO
        return $this->defaultDelete($entity, $extra);
    }

    private function administratorDelete($entity, $extra = null)
    {
        //TODO
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
            throw new Exception("NOT_TRASHED");
        }

        if (!$extra) {
            return $this->defaultDelete($entity);
        } else if ($extra->lisRole === 'student') {
            return $this->studentDelete($entity, $extra);
        } else if ($extra->lisRole === 'teacher') {
            //TODO
        } else if ($extra->lisRole === 'administrator') {
            //TODO
        }
    }

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
     * @param type $returnPartial
     * @param type $extra
     * 
     * @return array
     */
    private function studentGet($entity, $returnPartial = false, $extra = null)
    {
        if ($entity->getStudent()->getId() !== $extra->lisPerson->getId()) {
            throw new Exception('SELF_RELATED_RESTRICTION');
        }
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    private function teacherGet($entity, $returnPartial = false, $extra = null)
    {
        //TODO
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    private function administratorGet($entity, $returnPartial = false, $extra = null)
    {
        //TODO
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param int $id
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
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
            //TODO
        } else if ($extra->lisRole === 'administrator') {
            //TODO
        }
    }

    private function defaultGetList($params = null, $extra = null, $dqlRestriction = null)
    {
        $dql = $this->dqlStart();
        $dql .= $this->dqlWhere($params, $extra);

        if ($dqlRestriction) {
            $dql .= $dqlRestriction;
        }
        return $this->wrapPaginator($dql);
    }

    private function studentGetList($params = null, $extra = null)
    {
        $id = $extra->lisPerson->getId();
        $dqlRestriction = " AND $this->baseAlias.student=$id";
        return $this->defaultGetList($params, $extra, $dqlRestriction);
    }

    private function teacherGetList($params = null, $extra = null)
    {
        //TODO
        return $this->defaultGetList($params, $extra);
    }

    private function administratorGetList($params = null, $extra = null)
    {
        //TODO
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
            //TODO
        } else if ($extra->lisRole === 'administrator') {
            //TODO
        }
    }

}

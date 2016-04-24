<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity\Repository;

use Core\Entity\Absence;
use Exception;

/**
 * 
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AbsenceRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'absence';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\Absence';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        description,
                        trashed
                    },
                    partial student.{
                        id,
                        firstName,
                        lastName,
                        name,
                        personalCode
                        },
                    partial contactLesson.{
                        id,
                        name,
                        sequenceNr,
                        durationAK
                        },
                    partial absenceReason.{
                        id,
                        name
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.contactLesson contactLesson
                JOIN $this->baseAlias.student student
                LEFT JOIN $this->baseAlias.absenceReason absenceReason";
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
                        description,
                        trashed
                    },
                    partial student.{
                        id,
                        firstName,
                        lastName,
                        name,
                        personalCode
                        },
                    partial contactLesson.{
                        id,
                        name,
                        sequenceNr,
                        durationAK
                        },
                    partial absenceReason.{
                        id,
                        name
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.contactLesson contactLesson
                JOIN $this->baseAlias.student student
                LEFT JOIN $this->baseAlias.absenceReason absenceReason";
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
                        description,
                        trashed
                    },
                    partial student.{
                        id,
                        firstName,
                        lastName,
                        name,
                        personalCode
                        },
                    partial contactLesson.{
                        id,
                        name,
                        sequenceNr,
                        durationAK
                        },
                    partial absenceReason.{
                        id,
                        name
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.contactLesson contactLesson
                JOIN $this->baseAlias.student student
                LEFT JOIN $this->baseAlias.absenceReason absenceReason";
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
                        description,
                        trashed
                    },
                    partial student.{
                        id,
                        firstName,
                        lastName,
                        name,
                        personalCode
                        },
                    partial contactLesson.{
                        id,
                        name,
                        sequenceNr,
                        durationAK
                        },
                    partial absenceReason.{
                        id,
                        name
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.contactLesson contactLesson
                JOIN $this->baseAlias.student student
                LEFT JOIN $this->baseAlias.absenceReason absenceReason";
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
                new Absence($this->getEntityManager()), $data
        );
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
        if (!key_exists('student', $data)) {
            $data['student'] = $extra->lisPerson->getId();
        }
        if ($data['student'] !== $extra->lisPerson->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }

        //set user related data
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function teacherCreate($data, $returnPartial = false, $extra = null)
    {
        //set user related data
        $data['createdBy'] = $extra->lisUser->getId();
        $data['updatedBy'] = null;

        return $this->defaultCreate($data, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function administratorCreate($data, $returnPartial = false, $extra = null)
    {
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
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function defaultUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $entityValidated = $this->validateEntity(
                $entity, $data
        );
        return $this->singleResult($entityValidated, $returnPartial, $extra);
    }

    /**
     * SELF CREATED RESTRICTION
     * SELF RELATED RESTRICTION
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

        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }

        if ($data['student'] !== $extra->lisPerson->getId()) {
            throw new Exception('SELF_RELATED_RESTRICTION');
        }

        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * HAS SELF CREATED RESTRICTION
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
    private function teacherUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }
        
        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        return $this->defaultUpdate($entity, $data, $returnPartial, $extra);
    }

    /**
     * SELF CREATED RESTRICTION
     * 
     * @param type $entity
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function administratorUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }
        
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

    /**
     * SELF CREATED RESTRICTION
     * 
     * @param type $entity
     * @param type $extra
     */
    private function studentDelete($entity, $extra = null)
    {
        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }
        return $this->defaultDelete($entity, $extra);
    }

    /**
     * HAS SELF CREATED RESTRICTION
     * @param type $entity
     * @param type $extra
     * @return type
     * @throws Exception
     */
    private function teacherDelete($entity, $extra = null)
    {
        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }
        
        return $this->defaultDelete($entity, $extra);
    }

    /**
     * HAS SELF CREATED RESTRICTION
     * 
     * @param type $entity
     * @param type $extra
     * @return type
     */
    private function administratorDelete($entity, $extra = null)
    {
        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }
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

    /**
     * 
     * @param type $entity
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function teacherGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
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
            return $this->teacherGet($entity, $returnPartial, $extra);
        } else if ($extra->lisRole === 'administrator') {
            return $this->administratorGet($entity, $returnPartial, $extra);
        }
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     * @param type $dqlRestriction
     * @return type
     */
    private function defaultGetList($params = null, $extra = null, $dqlRestriction = null)
    {
        $dql = $this->dqlStart();
        $dql .= $this->dqlWhere($params, $extra);
        
        if($dqlRestriction) {
            $dql .= $dqlRestriction; 
        }
        return $this->wrapPaginator($dql);
    }
    
    /**
     * 
     * @param type $params
     * @param type $extra
     * @return type
     */
    private function studentGetList($params = null, $extra = null)
    {
        $id = $extra->lisPerson->getId();
        $dqlRestriction = " AND $this->baseAlias.student=$id";
        return $this->defaultGetList($params, $extra, $dqlRestriction);
    }
    
    /**
     * 
     * @param type $params
     * @param type $extra
     * @return type
     */
    private function teacherGetList($params = null, $extra = null)
    {
        $dqlRestriction = null;
        return $this->defaultGetList($params, $extra, $dqlRestriction);
    }
    
    /**
     * 
     * @param type $params
     * @param type $extra
     */
    private function administratorGetList($params = null, $extra = null)
    {
        //TODO
        $dqlRestriction = null;
        return $this->defaultGetList($params, $extra, $dqlRestriction);
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

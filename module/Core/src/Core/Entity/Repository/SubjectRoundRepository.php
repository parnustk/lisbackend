<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity\Repository;

use Core\Entity\SubjectRound;
use Exception;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Types\Type;
use DateTime;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Arnold Tserepov <tserepov@gmail.com>
 * @author Alar Aasa <alar@alaraasa.ee>
 */
class SubjectRoundRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    public $baseAlias = 'subjectround';

    /**
     *
     * @var string 
     */
    public $baseEntity = 'Core\Entity\SubjectRound';

    public function diaryRelatedDataIndependentWork($params = null, $extra = null)
    {
        $dql = "SELECT 
                    partial subjectround.{
                        id,
                        trashed
                    },
                    partial independentWork.{
                        id,
                        duedate,
                        name,
                        description,
                        durationAK
                    },
                    partial studentGrade.{
                        id
                    },
                    partial student.{
                        id,
                        name
                    },
                    partial teacher.{
                        id,
                        name
                    },
                    partial gradeChoice.{
                        id,
                        name
                    }
                    
                FROM Core\Entity\SubjectRound subjectround

                JOIN subjectround.studentGroup studentGroup
                JOIN subjectround.independentWork independentWork
                
                LEFT JOIN independentWork.studentGrade studentGrade
                LEFT JOIN studentGrade.student student
                LEFT JOIN studentGrade.teacher teacher
                LEFT JOIN studentGrade.gradeChoice gradeChoice
                
                WHERE 
                    subjectround.id=:subjectroundId AND 
                    studentGroup.id=:studentGroupId 
                
                ORDER BY independentWork.duedate ASC ";

        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter('subjectroundId', $params['where']->subjectRound->id, Type::INTEGER);
        $q->setParameter('studentGroupId', $params['where']->studentGroup->id, Type::INTEGER);
        //print_r($q->getSQL()); die();
        $q->setHydrationMode(Query::HYDRATE_ARRAY);
        return new Paginator(
                new DoctrinePaginator(new ORMPaginator($q))
        );
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     */
    public function diaryRelatedDataSubjectRound($params = null, $extra = null)
    {
        $dql = "SELECT 
                    partial subjectround.{
                        id,
                        trashed
                    },
                    partial studentGrade.{
                            id
                    },
                    partial student.{
                            id,
                            name
                    },
                    partial teacher.{
                            id,
                            name
                    },
                    partial gradeChoice.{
                            id,
                            name
                    }
                    
                FROM Core\Entity\SubjectRound subjectround
                
                JOIN subjectround.studentGroup studentGroup
                JOIN subjectround.studentGrade studentGrade
                
                LEFT JOIN studentGrade.student student
                LEFT JOIN studentGrade.teacher teacher
                LEFT JOIN studentGrade.gradeChoice gradeChoice
                
                WHERE 
                    subjectround.id=:subjectroundId AND 
                    studentGroup.id=:studentGroupId AND 
                    gradeChoice.lisType='gradechoice' ";

        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter('subjectroundId', $params['where']->subjectRound->id, Type::INTEGER);
        $q->setParameter('studentGroupId', $params['where']->studentGroup->id, Type::INTEGER);
        //print_r($q->getSQL()); die();
        $q->setHydrationMode(Query::HYDRATE_ARRAY);
        return new Paginator(
                new DoctrinePaginator(new ORMPaginator($q))
        );
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     */
    public function diaryRelatedData($params = null, $extra = null)
    {
        $dql = "SELECT 
                    partial subjectRound.{
                        id,
                        trashed
                    },
                    partial contactLesson.{
                            id,
                            name,
                            lessonDate,
                            description,
                            sequenceNr
                    },
                    partial studentGrade.{
                            id
                    },
                    partial student.{
                            id,
                            name
                    },
                    partial teacher.{
                            id,
                            name
                    },
                    partial gradeChoice.{
                            id,
                            name
                    }
                    
                FROM Core\Entity\SubjectRound subjectRound
                
                JOIN subjectRound.studentGroup studentGroup
                JOIN subjectRound.contactLesson contactLesson
                
                LEFT JOIN contactLesson.studentGrade studentGrade
                LEFT JOIN studentGrade.student student
                LEFT JOIN studentGrade.teacher teacher
                LEFT JOIN studentGrade.gradeChoice gradeChoice
                
                WHERE subjectRound.id = :subjectRoundId AND studentGroup.id=:studentGroupId 
                    
                ORDER BY contactLesson.lessonDate ASC, contactLesson.sequenceNr ASC ";

        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter('subjectRoundId', $params['where']->subjectRound->id, Type::INTEGER);
        $q->setParameter('studentGroupId', $params['where']->studentGroup->id, Type::INTEGER);

        $q->setHydrationMode(Query::HYDRATE_ARRAY);
        return new Paginator(
                new DoctrinePaginator(new ORMPaginator($q))
        );
    }

    public function studentAbsenceData($params = null, $extra = null)
    {
        $dql = "SELECT
                    partial subjectRound.{
                        id,
                        name,
                        status,
                        trashed
                    },
                    partial contactLesson.{
                        id,
                        name,
                        lessonDate,
                        sequenceNr,
                        description
                    },
                    partial teacher.{
                            id,
                            name
                    },
                    partial studentGrade.{
                            id
                    },
                    partial absenceReason.{
                            id,
                            name
                    },
                    partial rooms.{
                            id,
                            name
                    },
                    partial studentGroup.{
                            id,
                            name
                    },
                    partial student.{
                             id,
                             name
                     }
                    FROM Core\Entity\SubjectRound subjectRound
                    
                    JOIN subjectRound.studentGroup studentGroup
                    JOIN subjectRound.contactLesson contactLesson 
                    JOIN contactLesson.studentGrade studentGrade
                    LEFT JOIN studentGrade.student student
                    LEFT JOIN contactLesson.rooms rooms
                    LEFT JOIN studentGrade.gradeChoice absenceReason
                    LEFT JOIN contactLesson.teacher teacher ";


        if (array_key_exists('startDate', $params) && array_key_exists('endDate', $params)) {
             $dql .= " WHERE absenceReason.lisType='absencereason' AND student.id=:studentId AND contactLesson.lessonDate >=:startDateTime AND contactLesson.lessonDate <=:endDateTime ";
          } else {
             $dql .= " WHERE absenceReason.lisType='absencereason' AND student.id=:studentId ";
          }

        $dql .= " ORDER BY contactLesson.lessonDate DESC, contactLesson.sequenceNr ASC ";

        $q = $this->getEntityManager()->createQuery($dql);

        $q->setParameter('studentId', $extra->lisPerson->getId(), Type::INTEGER);

        if (array_key_exists('startDate', $params) && array_key_exists('endDate', $params)) {
            $q->setParameter('startDateTime', (new DateTime($params['startDate'])), Type::DATETIME);
            $q->setParameter('endDateTime', (new DateTime($params['endDate'])), Type::DATETIME);
        }

        $q->setHydrationMode(Query::HYDRATE_ARRAY);

        return new Paginator(
                new DoctrinePaginator(new ORMPaginator($q))
        );
    }

    public function studentTimeTableData($params = null, $extra = null)
    {

        $student = $extra->lisPerson;
        $r = $this->_em->getRepository('Core\Entity\StudentInGroups')->getStudentVocationByStudentId($student);
        $studentGroupId = -1;
        if (count($r) > 0) {
            $studentGroupId = $r[0]->getStudentGroup()->getId();
        }

        $dql = "SELECT
                    partial subjectRound.{
                        id,
                        name,
                        status,
                        trashed
                    },
                    partial contactLesson.{
                        id,
                        name,
                        lessonDate,
                        sequenceNr,
                        description
                    },
                    partial teacher.{
                            id,
                            name
                    },
                    partial rooms.{
                            id,
                            name
                    },
                    partial studentGroup.{
                            id,
                            name
                    }
                    FROM Core\Entity\SubjectRound subjectRound
                    JOIN subjectRound.contactLesson contactLesson
                    JOIN contactLesson.teacher teacher  
                    JOIN subjectRound.studentGroup studentGroup
                    JOIN contactLesson.rooms rooms";


        if (array_key_exists('startDate', $params) && array_key_exists('endDate', $params)) {
            $dql .= " WHERE studentGroup.id=:studentGroupId AND contactLesson.lessonDate >=:startDateTime AND contactLesson.lessonDate <=:endDateTime ";
        } else {
            $dql .= " WHERE studentGroup.id=:studentGroupId ";
        }

        $dql .= " ORDER BY contactLesson.lessonDate DESC, contactLesson.sequenceNr ASC ";

        $q = $this->getEntityManager()->createQuery($dql);

        $q->setParameter('studentGroupId', $studentGroupId, Type::INTEGER);

        if (array_key_exists('startDate', $params) && array_key_exists('endDate', $params)) {
            $q->setParameter('startDateTime', (new DateTime($params['startDate'])), Type::DATETIME);
            $q->setParameter('endDateTime', (new DateTime($params['endDate'])), Type::DATETIME);
        }

        $q->setHydrationMode(Query::HYDRATE_ARRAY);

        return new Paginator(
                new DoctrinePaginator(new ORMPaginator($q))
        );
    }

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        status,
                        trashed
                    },
                    partial vocation.{
                            id,
                            name
                    },
                    partial module.{
                            id,
                            name
                    },
                    partial subject.{
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
                    },
                    partial studentGrade.{
                            id
                    },
                    partial gradeChoice.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subject subject
                JOIN $this->baseAlias.studentGroup studentGroup
                LEFT JOIN $this->baseAlias.studentGrade studentGrade
                LEFT JOIN studentGrade.gradeChoice gradeChoice";
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
                        name,
                        status,
                        trashed
                    },
                    partial vocation.{
                            id,
                            name
                    },
                    partial module.{
                            id,
                            name
                    },
                    partial subject.{
                            id
                    },
                    partial studentGroup.{
                            id
                    },
                    partial teacher.{
                            id
                    },
                    partial studentGrade.{
                            id
                    },
                    partial gradeChoice.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subject subject
                JOIN $this->baseAlias.studentGroup studentGroup
                LEFT JOIN $this->baseAlias.studentGrade studentGrade
                LEFT JOIN studentGrade.gradeChoice gradeChoice";
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
                        name,
                        status,
                        trashed
                    },
                    partial vocation.{
                            id,
                            name
                    },
                    partial module.{
                            id,
                            name
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
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subject subject
                JOIN $this->baseAlias.studentGroup studentGroup";
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
                        name,
                        status,
                        trashed
                    },
                    partial vocation.{
                            id,
                            name
                    },
                    partial module.{
                            id,
                            name
                    },
                    partial subject.{
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
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subject subject
                JOIN $this->baseAlias.studentGroup studentGroup";
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @return type
     */
    private function defaultCreate($data, $returnPartial = false, $extra = null)
    {
        if (count($data) < 1) {
            throw new Exception('NO_DATA');
        }

        $entity = new SubjectRound($this->getEntityManager());

        $subject = $this->getEntityManager()
                ->getRepository('Core\Entity\Subject')
                ->find($data['subject']);

        $entity->setName($subject->getName());

        $entityValidated = $this->validateEntity(
                $entity, $data
        );
        return $this->singleResult($entityValidated, $returnPartial, $extra);
    }

    /**
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

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function teacherCreate($data, $returnPartial = false, $extra = null)
    {
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
//IF required MANY TO MANY validate manually
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
    private function administratorUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
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
     * 
     * @param type $entity
     * @param type $extra
     */
    private function studentDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $extra
     * @return type
     */
    private function teacherDelete($entity, $extra = null)
    {
        return $this->defaultDelete($entity, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $extra
     * @return type
     */
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
     * @param type $id
     * @param type $returnPartial
     * @param type $extra
     * @return type
     */
    private function defaultGet($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            return $this->singlePartialById($id, $extra);
        }
        return $this->find($id);
    }

    /**
     * 
     * @param type $entity
     * @param type $returnPartial
     * @param type $extra
     * 
     * @return array
     */
    private function studentGet($entity, $returnPartial = false, $extra = null)
    {
        return $this->defaultGet($entity->getId(), $returnPartial, $extra);
    }

    /**
     * 
     * @param type $entity
     * @param type $extra
     * @return boolean
     */
    private function findingTeacher($entity, $extra)
    {
        $teacherNotExists = true;
        foreach ($entity->getTeacher() as $teacher) {
            if ($teacher->getId() === $extra->lisPerson->getId()) {
                $teacherNotExists = false;
            }
        }
        if ($teacherNotExists) {
            throw new Exception('SELF_RELATED_RESTRICTION');
        }
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
        $this->findingTeacher($entity, $extra);
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

        if ($dqlRestriction) {
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
        if (array_key_exists('studentAbsence', $params)) {
            return $this->studentAbsenceData($params, $extra);
        } else if (array_key_exists('studentTimeTable', $params)) {
            return $this->studentTimeTableData($params, $extra);
        }

        $id = $extra->lisPerson->getId();
        return $this->defaultGetList($params, $extra);
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     * @return type
     */
    private function teacherGetList($params = null, $extra = null)
    {
        print_r($params);
        if (array_key_exists('diaryview', $params)) {
            switch ($params['diaryview']) {
                case 'diaryview':
                    return $this->diaryRelatedData($params, $extra);
                case 'diaryviewsr':
                    return $this->diaryRelatedDataSubjectRound($params, $extra);
                case 'diaryviewiw':
                    return $this->diaryRelatedDataIndependentWork($params, $extra);
            }
        }
        //$this->findingTeacher($entity, $extra);
        $id = $extra->lisPerson->getId();
        $dqlRestriction = " AND teacher=$id"; //TODO uncomment remove afterwoods
        return $this->defaultGetList($params, $extra, $dqlRestriction);
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     * @return type
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
            throw new Exception('MISSING_ROLE_GETLIST');
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

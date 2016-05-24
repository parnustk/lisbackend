<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity\Repository;

use Core\Entity\ContactLesson;
use Exception;
use Zend\Json\Json;
use DateTime;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Types\Type;

/**
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ContactLessonRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    public $baseAlias = 'contactLesson';

    /**
     *
     * @var string 
     */
    public $baseEntity = 'Core\Entity\ContactLesson';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        //studentGrade rquires some thinking
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        lessonDate,
                        description,
                        sequenceNr,
                        trashed
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial module.{
                        id,
                        name
                    },
                    partial vocation.{
                        id,
                        name
                    },
                    partial teacher.{
                        id,
                        name
                    },
                    partial rooms.{
                        id,
                        name
                    },
                    partial studentGrade.{
                        id
                    },
                    partial studentGroup.{
                    id,
                    name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.studentGroup studentGroup
                LEFT JOIN $this->baseAlias.rooms rooms
                LEFT JOIN $this->baseAlias.studentGrade studentGrade";
    }

    protected function lessonReportData($params = null, $extra = null)
    {
        if (!array_key_exists('teacherId', $params)) {
            throw new Exception('LIS_MISSING_TEACHERID');
        }
        $dql = "SELECT 
                    COUNT(contactLesson.id) as ak,
                    partial contactLesson.{
                        id,
                        lessonDate
                    },
                    partial subjectRound.{
                        id,
                        name
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
                FROM Core\Entity\ContactLesson contactLesson
                JOIN contactLesson.teacher teacher
                JOIN contactLesson.subjectRound subjectRound
                JOIN contactLesson.studentGroup studentGroup
                JOIN contactLesson.rooms rooms ";


        if (array_key_exists('startDate', $params) && array_key_exists('endDate', $params)) {

            $dql .= " WHERE teacher.id=:teacherId AND contactLesson.lessonDate >=:startDateTime AND contactLesson.lessonDate <=:endDateTime ";
        
        } else {

            $dql .= " WHERE teacher.id=:teacherId ";
            
        }

        $dql .=" GROUP BY contactLesson.lessonDate 
                 ORDER BY contactLesson.lessonDate DESC ";

        $q = $this->getEntityManager()->createQuery($dql);

        $q->setParameter('teacherId', $params['teacherId'], Type::INTEGER);

        if (array_key_exists('startDate', $params) && array_key_exists('endDate', $params)) {
            $q->setParameter('startDateTime', (new DateTime($params['startDate'])), Type::DATETIME);
            $q->setParameter('endDateTime', (new DateTime($params['endDate'])), Type::DATETIME);
        }

        return $q->execute(null, Query::HYDRATE_ARRAY);
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
                        lessonDate,
                        description,
                        sequenceNr,
                        trashed
                    },
                    partial subjectRound.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial rooms.{
                        id
                        },
                    partial studentGrade.{
                        id
                        },
                    partial studentGroup.{
                    id,
                    name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.studentGroup studentGroup
                LEFT JOIN $this->baseAlias.rooms rooms
                LEFT JOIN $this->baseAlias.studentGrade studentGrade";
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
                        lessonDate,
                        description,
                        sequenceNr,
                        trashed
                    },
                    partial subjectRound.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial rooms.{
                        id
                        },
                    partial studentGrade.{
                        id
                        },
                    partial studentGroup.{
                    id,
                    name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.studentGroup studentGroup
                LEFT JOIN $this->baseAlias.rooms rooms
                LEFT JOIN $this->baseAlias.studentGrade studentGrade";
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
                        lessonDate,
                        description,
                        sequenceNr,
                        trashed
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial module.{
                        id,
                        name
                    },
                    partial vocation.{
                        id,
                        name
                    },
                    partial teacher.{
                        id,
                        name
                    },
                    partial rooms.{
                        id,
                        name
                    },
                    partial studentGrade.{
                        id
                    },
                    partial studentGroup.{
                    id,
                    name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subjectRound subjectRound
                JOIN $this->baseAlias.module module
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.studentGroup studentGroup
                LEFT JOIN $this->baseAlias.rooms rooms
                LEFT JOIN $this->baseAlias.studentGrade studentGrade";
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
        //throw new Exception($data['lessonDate']);
        $this->validateSubjectRound($data);
        $entity = new ContactLesson($this->getEntityManager());
        $subjectRound = $this->getEntityManager()
                ->getRepository('Core\Entity\SubjectRound')
                ->find($data['subjectRound']);

        unset($data['subjectRound']);
        $entity->setSubjectRound($subjectRound);

        $studentGroup = $this->getEntityManager()
                ->getRepository('Core\Entity\StudentGroup')
                ->find($data['studentGroup']);

        try {
            if (is_string($data['lessonDate']) && !is_object($data['lessonDate'])) {
                $data['lessonDate'] = new DateTime($data['lessonDate']);
            }
            //TA2-16.04.2016-2
            $data['name'] = $studentGroup->getName() . '-' .
                    $data['lessonDate']->format('d.m.Y') . '-' . $data['sequenceNr'];
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }

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

    private function validateSubjectRound($data)
    {
        if (!key_exists('subjectRound', $data)) {
            throw new Exception(
            Json::encode(
                    'Missing subject round for contact lesson', true
            )
            );
        }

        if (!$data['subjectRound']) {
            throw new Exception(
            Json::encode(
                    'Missing subject round for contact lesson', true
            )
            );
        }
    }

    /**
     * Special case for subject round
     * 
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function defaultUpdate($entity, $data, $returnPartial = false, $extra = null)
    {

        $this->validateSubjectRound($data);

        $subjectRound = $this->getEntityManager()
                ->getRepository('Core\Entity\SubjectRound')
                ->find($data['subjectRound']);

        $entity->setSubjectRound($subjectRound);

        unset($data['subjectRound']);

        $entity->hydrate($data, $this->getEntityManager());

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers for contact lesson', true));
        }
//        $this->getEntityManager()->persist($entity);
//        $this->getEntityManager()->flush($entity);

        return $this->singleResult($entity, $returnPartial, $extra);
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
        return $this->defaultGetList($params, $extra);
    }

    /**
     * 
     * @param type $params
     * @param type $extra
     * @return type
     */
    private function administratorGetList($params = null, $extra = null)
    {
        if (array_key_exists('lessonReport', $params)) {
            return $this->lessonReportData($params, $extra);
        }
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

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity\Repository;

use Core\Entity\Module;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Types\Type;
use DateTime;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class ModuleRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    public $baseAlias = 'module';

    /**
     *
     * @var string 
     */
    public $baseEntity = 'Core\Entity\Module';

    protected function studentModuleGradesData($params = null, $extra = null)
    {
        $student = $extra->lisPerson;
        $r = $this->_em->getRepository('Core\Entity\StudentInGroups')->getStudentVocationByStudentId($student);
        $vocationId = -1;
        $studentGroupId = -1;
        if (count($r) > 0) {
            $vocationId = $r[0]->getStudentGroup()->getVocation()->getId();
            $studentGroupId = $r[0]->getStudentGroup()->getId();
        }

        $dql = "SELECT 
                    partial module.{
                        id,
                        name,
                        duration
                    },
                    partial vocation.{
                        id,
                        name
                    },
                    partial subjectRound.{
                        id,
                        name
                    },
                    partial studentGrade.{
                        id
                    },
                    partial gradingType.{
                        id,
                        name
                    },
                    partial gradeChoice.{
                        id,
                        name
                    },
                    partial studentGradeSR.{
                            id
                    },
                    partial gradeChoiceSR.{
                        id,
                        name
                    },
                    partial contactLesson.{
                        id,
                        name,
                        lessonDate,
                        sequenceNr,
                        description
                    },
                    partial studentGradeCL.{
                        id
                    },
                    partial gradeChoiceCL.{
                        id,
                        name
                    },
                    partial teacherCL.{
                        id,
                        name
                    },
                    partial roomsCL.{
                        id,
                        name
                    },
                    partial independentWork.{
                        id,
                        name,
                        duedate,
                        description,
                        durationAK
                    },
                    partial teacherIW.{
                        id,
                        name
                    },
                    partial studentGradeIW.{
                        id
                    },
                    partial gradeChoiceIW.{
                        id,
                        name
                    },
                    partial subjectRoundCL.{
                    id,
                    name
                    }
                FROM Core\Entity\Module module
                JOIN module.vocation vocation
                LEFT JOIN module.gradingType gradingType
                
                LEFT JOIN module.subjectRound subjectRound
                LEFT JOIN subjectRound.studentGroup studentGroup
                
                LEFT JOIN module.studentGrade studentGrade
                LEFT JOIN studentGrade.student student
                
                LEFT JOIN studentGrade.gradeChoice gradeChoice
                LEFT JOIN subjectRound.studentGrade studentGradeSR
                LEFT JOIN studentGradeSR.gradeChoice gradeChoiceSR
                LEFT JOIN studentGradeSR.student studentSR
                
                LEFT JOIN subjectRound.contactLesson contactLesson
                LEFT JOIN contactLesson.studentGrade studentGradeCL
                LEFT JOIN contactLesson.teacher teacherCL
                LEFT JOIN contactLesson.rooms roomsCL
                LEFT JOIN contactLesson.subjectRound subjectRoundCL
                LEFT JOIN studentGradeCL.gradeChoice gradeChoiceCL
                LEFT JOIN studentGradeCL.student studentCL

                LEFT JOIN subjectRound.independentWork independentWork
                LEFT JOIN independentWork.studentGrade studentGradeIW
                LEFT JOIN independentWork.teacher teacherIW
                LEFT JOIN studentGradeIW.gradeChoice gradeChoiceIW
                LEFT JOIN studentGradeIW.student studentIW

                WHERE 
                    vocation.id=:vocationId AND
                    studentGroup.id=:studentGroupId AND
                    (gradeChoiceCL.lisType ='gradechoice' OR gradeChoiceCL.lisType IS NULL) AND
                    (student.id=:studentId OR student.id IS NULL) AND
                    (studentSR.id=:studentId OR studentSR.id IS NULL) AND
                    (studentCL.id=:studentId OR studentCL.id IS NULL) AND
                    (studentIW.id=:studentId OR studentIW.id IS NULL) ";

        if (array_key_exists('startDateIW', $params) && array_key_exists('endDateIW', $params)) {//we have startDate and endDate from params add criteria to query
            $dql .= " WHERE studentIW.id=:studentId AND independentWork.duedate >=:startDateTimeIW AND independentWork.duedate <=:endDateTimeIW ";
        }
        
        if (array_key_exists('startDateCL', $params) && array_key_exists('endDateCL', $params)) {//we have startDate and endDate from params add criteria to query
            $dql .= " WHERE studentCL.id=:studentId AND contactLesson.lessonDate >=:startDateTimeCL AND contactLesson.lessonDate <=:endDateTimeCL";
        }

        $dql .= " ORDER BY independentWork.duedate ASC, contactLesson.lessonDate ASC";

        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter('vocationId', $vocationId, Type::INTEGER);
        $q->setParameter('studentGroupId', $studentGroupId, Type::INTEGER);
        $q->setParameter('studentId',  $student->getId(), Type::INTEGER);

        if (array_key_exists('startDateIW', $params) && array_key_exists('endDateIW', $params)) {//we have startDate and endDate from params add bind values to criteria
            $q->setParameter('startDateTimeIW', (new DateTime($params['startDateIW'])), Type::DATETIME);
            $q->setParameter('endDateTimeIW', (new DateTime($params['endDateIW'])), Type::DATETIME);
        }
        
        if (array_key_exists('startDateCL', $params) && array_key_exists('endDateCL', $params)) {//we have startDate and endDate from params add bind values to criteria
            $q->setParameter('startDateTimeCL', (new DateTime($params['startDateCL'])), Type::DATETIME);
            $q->setParameter('endDateTimeCL', (new DateTime($params['endDateCL'])), Type::DATETIME);
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
                        duration,
                        moduleCode,
                        trashed
                    },
                    partial vocation.{
                        id,
                        name,
                        vocationCode
                    },
                    partial moduleType.{
                        id,
                        name
                    },
                    partial gradingType.{
                        id,
                        name
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.vocation vocation
                JOIN $this->baseAlias.moduleType moduleType 
                JOIN $this->baseAlias.gradingType gradingType";
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
                        duration,
                        moduleCode,
                        trashed
                    },
                    partial vocation.{
                    id
                    },
                    partial moduleType.{
                    id
                    },
                    partial gradingType.{
                    id,
                    name
                    }
                    FROM $this->baseEntity $this->baseAlias
                    JOIN $this->baseAlias.vocation vocation
                    JOIN $this->baseAlias.moduleType moduleType 
                    JOIN $this->baseAlias.gradingType gradingType";
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
                        duration,
                        moduleCode,
                        trashed
                    },
                    partial vocation.{
                    id
                    },
                    partial moduleType.{
                    id
                    },
                    partial gradingType.{
                    id,
                    name
                    }
                    FROM $this->baseEntity $this->baseAlias
                    JOIN $this->baseAlias.vocation vocation
                    JOIN $this->baseAlias.moduleType moduleType 
                    JOIN $this->baseAlias.gradingType gradingType";
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
                        duration,
                        moduleCode,
                        trashed
                    },
                    partial vocation.{
                        id,
                        name,
                        vocationCode
                    },
                    partial moduleType.{
                        id
                    },
                    partial gradingType.{
                        id,
                        name
                    }
                    FROM $this->baseEntity $this->baseAlias
                    JOIN $this->baseAlias.vocation vocation
                    JOIN $this->baseAlias.moduleType moduleType 
                    JOIN $this->baseAlias.gradingType gradingType";
    }

    /**
     * 
     * @param type $data
     * @throws Exception
     */
    private function validateVocation($data)
    {
        if (!key_exists('vocation', $data)) {
            throw new Exception(
            Json::encode(
                    'Missing vocation for module', true
            )
            );
        }

        if (!$data['vocation']) {
            throw new Exception(
            Json::encode(
                    'Missing vocation for module', true
            )
            );
        }
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return GradingType
     * @throws Exception
     */
    public function defaultCreate($data, $returnPartial = false, $extra = null)
    {
        $this->validateVocation($data);

        $entity = new Module($this->getEntityManager());

        $vocation = $this->getEntityManager()
                ->getRepository('Core\Entity\Vocation')
                ->find($data['vocation']);

        $entity->setVocation($vocation);

        unset($data['vocation']);

        $entity->hydrate($data, $this->getEntityManager());

        $entityValidated = $this->validateEntity(
                $entity, $data
        );

        //manytomany validate manually
        if (!count($entity->getGradingType())) {
            throw new Exception(Json::encode('MISSING_GRADING_TYPES', true));
        }

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
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function administratorCreate($data, $returnPartial = false, $extra = null)
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
        $this->validateVocation($data);

        $vocation = $this->getEntityManager()
                ->getRepository('Core\Entity\Vocation')
                ->find($data['vocation']);

        $entity->setVocation($vocation);

        unset($data['vocation']);

        $entity->hydrate($data, $this->getEntityManager());

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        //manytomany validate manually
        if (!count($entity->getGradingType())) {
            throw new Exception(Json::encode('MISSING_GRADING_TYPES', true));
        }
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
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function administratorUpdate($entity, $data, $returnPartial = false, $extra = null)
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
        //throw new Exception($dql);//debug dql from front
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
        if (array_key_exists('studentModuleGrades', $params)) {
            return $this->studentModuleGradesData($params, $extra);
        }

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

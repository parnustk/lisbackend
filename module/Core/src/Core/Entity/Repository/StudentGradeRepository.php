<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Core\Entity\StudentGrade;
use Exception;

/**
 * StudentGradeRepository
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
                LEFT JOIN $this->baseAlias.contactLesson contactlesson
                JOIN $this->baseAlias.student student
                JOIN $this->baseAlias.gradeChoice gradeChoice
                JOIN $this->baseAlias.teacher teacher
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
    public function Create($data, $returnPartial = false, $extra = null)
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
     * 
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                $this->find($id), $data
        );
        //validate that exactly one of four(contactLesson or module or subjectRound or independentWork) is present
        $notValid = $this->validateInputRelationExists($data);
        if ($notValid) {//if validates is still false throw exception
            throw new Exception('Missing or incorrect input');
        }
        
        return $this->singleResult($entity, $returnPartial, $extra);
    }

}

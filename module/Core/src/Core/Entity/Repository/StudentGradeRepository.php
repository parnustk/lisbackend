<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StudentGradeRepository
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentGradeRepository extends EntityRepository
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
                LEFT JOIN $this->baseAlias.absenceReason absenceReason
                JOIN $this->baseAlias.gradeChoice gradeChoice
                JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.independentWork independentWork
                LEFT JOIN $this->baseAlias.module module
                LEFT JOIN $this->baseAlias.subjectRound subjectRound";
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
        //validate that exactly one of four(contactLesson or module or subjectRound or independentWork) is present
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

        return $this->singleResult($entity, $returnPartial, $extra);
    }

}

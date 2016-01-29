<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * @author    Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */

namespace Core\Entity\Repository;

use Core\Entity\ContactLesson;

/**
 * @author    Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>@author sander
 */
class ContactLessonRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'contactlesson';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\ContactLesson';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        lessonDate,
                        description,
                        durationAK
                    },
                    partial subjectRound.{
                        id
                        },
                    partial teacher.{
                        id
                        },
                    partial absence.{
                        id
                        },
                    partial rooms.{
                        id
                        },
                    partial studentGrade.{
                        id
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.subjectRound subjectRound
                JOIN $this->baseAlias.teacher teacher
                LEFT JOIN $this->baseAlias.absence absence
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
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new ContactLesson($this->getEntityManager()), $data
        );
        //IF required MANY TO MANY validate manually
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
//        print_r($data);
//        $entity = $this->find($id);
//        try {
//            if (!$entity->hydrate($data)) {
//                throw new Exception(Json::encode($entity->getMessages(), true));
//            }
//        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//        }
//die('HERE 1231231321321');
        $entity = $this->validateEntity(
                $this->find($id), $data
        );
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entity, $returnPartial, $extra);
    }

}

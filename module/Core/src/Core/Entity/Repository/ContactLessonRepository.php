<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity\Repository;

use Core\Entity\ContactLesson;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
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
        $entity = $this->find($id);
        $entity->setEntityManager($this->getEntityManager());
//        print_r($entity->extract()); die();
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers for contact lesson', true));
        }
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {
            $dql = "
                    SELECT
                        partial cl.{
                            id,
                            lessonDate,
                            description,
                            durationAK
                        },
                        partial t. {
                            id
                        }
                    FROM Core\Entity\ContactLesson cl
                    JOIN cl.teacher t
                    WHERE cl.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }

}

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
use Exception;
use Zend\Json\Json;

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
                        durationAK,
                        trashed
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
                JOIN $this->baseAlias.subjectRound subjectRound
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
        $this->validateSubjectRound($data);
        $entity = new ContactLesson($this->getEntityManager());
        $subjectRound = $this->getEntityManager()
                ->getRepository('Core\Entity\SubjectRound')
                ->find($data['subjectRound']);
        unset($data['subjectRound']);
        $entity->setSubjectRound($subjectRound);
        $entity = $this->validateEntity(
                $entity, $data
        );
        

        
//        print_r($entity->getArrayCopy());die('HERE');
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entity, $returnPartial, $extra);
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
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {

        $this->validateSubjectRound($data);
        $entity = $this->find($id);

        $subjectRound = $this->getEntityManager()
                ->getRepository('Core\Entity\SubjectRound')
                ->find($data['subjectRound']);

        $entity->setSubjectRound($subjectRound);

        unset($data['subjectRound']);

        $entity->hydrate($data);

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

}

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
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
                        id
                        },
                    partial contactlesson.{
                        id
                        },
                    partial absenceReason.{
                        id
                        }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.contactLesson contactlesson
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
     * Restriction only self created
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
            //TODO
        } else if ($extra->lisRole === 'administrator') {
            //TODO
        }
    }

    private function defaultUpdate($entity, $data, $returnPartial = false, $extra = null)
    {
        $entityValidated = $this->validateEntity(
                $entity, $data
        );
        return $this->singleResult($entityValidated, $returnPartial, $extra);
    }

    /**
     * Self created and self related restriction
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
        //check that createdBy equals to current user
        if ($entity->getCreatedBy()->getId() !== $extra->lisUser->getId()) {
            throw new Exception('SELF_CREATED_RESTRICTION');
        }

        //check that incoming student id equals to lisPerson
        if ($data['student'] !== $extra->lisPerson->getId()) {
            throw new Exception('SELF_RELATED_RESTRICTION');
        }

        //set user related data
        $data['createdBy'] = null;
        $data['updatedBy'] = $extra->lisUser->getId();

        //all good update
        $entityValidated = $this->validateEntity(
                $entity, $data
        );

        return $this->singleResult($entityValidated, $returnPartial, $extra);
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

    private function defaultDelete($entity, $extra = null)
    {
        $id = $entity->getId();
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return $id;
    }

    /**
     * Self created restriction
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
            return $this->defaultDelete($entity, $extra);
        } else if ($extra->lisRole === 'student') {
            return $this->studentDelete($entity, $extra);
        } else if ($extra->lisRole === 'teacher') {
            //TODO
        } else if ($extra->lisRole === 'administrator') {
            //TODO
        }
    }

}

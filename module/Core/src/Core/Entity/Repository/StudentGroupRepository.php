<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity\Repository;

use Core\Entity\StudentGroup;

/**
 * StudentGroupRepository
 * 
 * @author Kristen <seppkristen@gmail.com>
 */
class StudentGroupRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'studentgroup';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\StudentGroup';

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
                        trashed
                    }
                FROM $this->baseEntity $this->baseAlias";
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
                new StudentGroup($this->getEntityManager()), $data
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
        $entity = $this->validateEntity(
                $this->find($id), $data
        );
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entity, $returnPartial, $extra);
    }

}

<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity\Repository;

use Core\Entity\StudentInGroups;

/**
 * Description of StudentInGroupsRepository
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class StudentInGroupsRepository extends AbstractBaseRepository
{
    /**
     *
     * @var string
     */
    protected $baseAlias = 'studentInGroups';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\StudentInGroups';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        //TODO
        return "";
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
                new StudentInGroups($this->getEntityManager()), $data
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

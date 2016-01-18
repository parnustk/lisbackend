<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity\Repository;

use Core\Entity\IndependentWork;

/**
 * @author Kristen <seppkristen@gmail.com>
 */
class IndependentWorkRepository extends AbstractBaseRepository
{

    /**
     * Using for dynamiq dql
     * protected type can be 
     * seeing in parent class also
     * @var type 
     */
    protected $baseAlias = 'independentwork';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\IndependentWork';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        $dql = "SELECT 
                    partial $this->baseAlias.{
                        id,
                        duedate,
                        description,
                        durationAK,
                        trashed
                    }
                FROM Core\Entity\IndependentWork $this->baseAlias";

        return $dql;
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
                new IndependentWork($this->getEntityManager()), $data
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

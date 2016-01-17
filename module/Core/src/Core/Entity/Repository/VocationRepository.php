<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity\Repository;

use Core\Entity\Vocation;

/**
 * VocationRepository
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 */
class VocationRepository extends AbstractBaseService implements CRUD
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'vocation';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\Vocation';

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
                        code,
                        durationEKAP,
                        trashed
                    }
                FROM $this->baseEntity $this->baseAlias";
    }

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        $dql = $this->dqlStart();
        $dql .= $this->dqlWhere($params, $extra);
        return $this->wrapPaginator($dql);
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
        if ($returnPartial) {
            return $this->singlePartialById($id, $extra);
        }
        return $this->find($id);
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
                new Vocation($this->getEntityManager()), $data
        );
        //IF required MANY TO MANY validate manually
        $this->saveEntity($entity);
        if ($returnPartial) {
            return $this->singlePartialById($entity->getId(), $extra);
        }
        return $entity;
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
        $this->saveEntity($entity);
        if ($returnPartial) {
            return $this->singlePartialById($id, $extra);
        }
        return $entity;
    }

    /**
     * 
     * @param int $id
     * @param type $extra
     * @return int
     */
    public function Delete($id, $extra = null)
    {
        return $this->deleteOnlyTrashed($id, $extra);
    }

}

<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 */

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Types\Type;
use Exception;
use Zend\Json\Json;

/**
 * Contains common methods for all repositories
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
abstract class AbstractBaseService extends EntityRepository
{

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     * @return string
     */
    protected function dqlWhere($params, $extra = null)
    {
        $dql = '';

        if (!!$params['where']) {//if where is not null
            $dql .= " WHERE";
            $firstCycle = true;
            foreach ($params['where'] as $key => $value) {
                if (!$firstCycle) {
                    $dql .= ' AND';
                } else {
                    $firstCycle = false;
                }
                $dql .= " $this->baseAlias.$key=$value";
            }
        } else {//default WHERE has trashed IS NULL for now nothing else
            $dql .= " WHERE $this->baseAlias.trashed IS NULL";
        }
        return $dql;
    }

    /**
     * 
     * @param string $dql
     * @return Paginator
     */
    protected function wrapPaginator($dql)
    {
        return new Paginator(
                new DoctrinePaginator(
                new ORMPaginator(
                $this->getEntityManager()
                        ->createQuery($dql)
                        ->setHydrationMode(Query::HYDRATE_ARRAY)
                )
                )
        );
    }

    /**
     * 
     * @param string $id
     * @param stdClass|null $extra
     * @param int $hydrateMethod
     * @return mixed
     */
    protected function singlePartialById($id, $extra = null, $hydrateMethod = Query::HYDRATE_ARRAY)
    {
        if (!!$extra) {
            //todo if needed. probably role based approach
            //student can only update rows created by him/herself
        }
        $dql = $this->dqlStart();
        $dql .= " WHERE $this->baseAlias.id = :id";
        $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
        $q->setParameter('id', $id, Type::INTEGER);
        return $q->getSingleResult($hydrateMethod);
    }

    /**
     * 
     * @param Entity $entity
     * @param array $data
     * @return Entity
     * @throws Exception
     */
    protected function validateEntity($entity, $data)
    {
        if (!$entity->hydrate($data)->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        return $entity;
    }

    /**
     * 
     * @param Entity $entity
     * @return void
     */
    protected function saveEntity($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }

    /**
     * 
     * @param int $id
     * @param stdClass|null $extra
     * @return int
     * @throws Exception
     */
    protected function deleteOnlyTrashed($id, $extra = null)
    {
        if (!!$extra) {
            //todo if needed. probably role based approach
            //student can only delete rows created by him/herself
        }
        $entity = $this->find($id);
        if ($entity->getTrashed()) {//cannot trash if trashed is not 1 !!null === false 
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        } else {
            throw new Exception("Not trashed. Can not delete.");
        }
        return $id;
    }

}

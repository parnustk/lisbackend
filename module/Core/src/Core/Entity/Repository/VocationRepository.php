<?php

namespace Core\Entity\Repository;

use Core\Entity\Vocation;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * @author sander
 */
class VocationRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param array|null $params
     * @param stdClass|null $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        if ($params) {
            //todo if neccessary
        }

        $dql = "SELECT 
                    partial vocation.{
                        id,
                        name, 
                        code, 
                        durationEKAP
                    }
                FROM Core\Entity\Vocation vocation
                WHERE vocation.trashed IS NULL";

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
     * @param int $id
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            $dql = "SELECT 
                        partial vocation.{
                            id,
                            name,
                            code,
                            durationEKAP
                        }
                    FROM Core\Entity\Vocation vocation
                    WHERE vocation.id = :id";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $q->setParameter('id', $id);

            return $q->getSingleResult(Query::HYDRATE_ARRAY);
        }
        return $this->find($id);
    }

    /**
     * 
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return Vocation|array
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new Vocation($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "SELECT 
                        partial vocation.{
                            id,
                            name,
                            code,
                            durationEKAP
                        }
                    FROM Core\Entity\Vocation vocation
                    WHERE vocation.id = " . $entity->getId();

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }

    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return type
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->find($id);
        $entity->setEntityManager($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {
            $dql = "
                    SELECT 
                        partial v.{id,name, code, durationEKAP}
                    FROM Core\Entity\Vocation v
                    WHERE v.id = " . $id;
            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
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
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
        return $id;
    }

}

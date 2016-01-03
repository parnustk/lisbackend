<?php

namespace Core\Entity\Repository;

use Core\Entity\Module;
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
class ModuleRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param stdClass $params
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        if ($params) {
            //use if neccessary
        }

        $dql = "SELECT 
                    partial m.{id,name,duration,code},
                    partial vocation.{id,name,code,durationEKAP},
                    partial moduleType.{id,name},
                    partial gradingType.{id,gradingType}
                FROM Core\Entity\Module m
                JOIN m.vocation vocation 
                JOIN m.moduleType moduleType
                JOIN m.gradingType gradingType";

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
     * @param array $data
     * @param boolean $returnPartial
     * @return mixed
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {

        $entity = new Module($this->getEntityManager());

        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        //manytomany validate manually
        if (!count($entity->getGradingType())) {
            throw new Exception(Json::encode('Missing gradingType', true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial m.{id,name,duration,code},
                        partial vocation.{id,name,code,durationEKAP},
                        partial moduleType.{id,name},
                        partial gradingType.{id,gradingType}
                    FROM Core\Entity\Module m
                    JOIN m.vocation vocation 
                    JOIN m.moduleType moduleType
                    JOIN m.gradingType gradingType 
                    WHERE m.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }
        return $entity;
    }

    public function Get($id, $returnPartial = false, $extra = null)
    {
        if ($returnPartial) {
            $dql = "
                    SELECT 
                        partial m.{id,name,duration,code},
                        partial vocation.{id,name,code,durationEKAP},
                        partial moduleType.{id,name},
                        partial gradingType.{id,gradingType}
                    FROM Core\Entity\Module m
                    JOIN m.vocation vocation 
                    JOIN m.moduleType moduleType
                    JOIN m.gradingType gradingType 
                    WHERE m.id = " . $id . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());

            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            return $r;
        }
        return $this->find($id);
    }

    /**
     * 
     * @param int $id
     * @param array $data
     * @param bool $returnPartial
     * @return mixed
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
                        partial m.{id,name,duration,code},
                        partial vocation.{id,name,code,durationEKAP},
                        partial moduleType.{id,name},
                        partial gradingType.{id,gradingType}
                    FROM Core\Entity\Module m
                    JOIN m.vocation vocation 
                    JOIN m.moduleType moduleType
                    JOIN m.gradingType gradingType 
                    WHERE m.id = " . $id . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

            return $r;
        }
        return $entity;
    }

    /**
     * 
     * @param type $id
     */
    public function Delete($id, $extra = null)
    {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
        return $id;
    }

}

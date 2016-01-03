<?php

namespace Core\Entity\Repository;

use Core\Entity\ContactLesson;
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
class ContactLessonRepository extends EntityRepository implements CRUD
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

        $dql = "SELECT partial cl.{id,bigint} 
                    FROM Core\Entity\ContactLesson cl";

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

    public function Get($id, $returnPartial = false, $extra = null)
    {
//        if ($returnPartial) {
//            $dql = "
//                    SELECT 
//                        partial mt.{id,name}
//                    FROM Core\Entity\ModuleType mt
//                    WHERE mt.id = " . $id . "
//                ";
//
//            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
//
//            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
//            return $r;
//        }
//        return $this->find($id);
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @return ModuleType
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {

        $entity = new ContactLesson($this->getEntityManager());

        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        //manytomany validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers', true));
        }
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial cl.{id,description}
                    FROM Core\Entity\ContactLesson cl
                    WHERE cl.id = " . $entity->getId() . "
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
     * @param type $data
     * @return Sample
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
//        $entity = $this->find($id);
//        $entity->setEntityManager($this->getEntityManager());
//        $entity->hydrate($data);
//
//        if (!$entity->validate()) {
//            throw new Exception(Json::encode($entity->getMessages(), true));
//        }
//
//        $this->getEntityManager()->persist($entity);
//        $this->getEntityManager()->flush($entity);
//
//        if ($returnPartial) {
//            $dql = "
//                    SELECT partial mt.{id,name}
//                    FROM Core\Entity\ModuleType mt
//                    WHERE mt.id = " . $id . "
//                ";
//            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
//
//            $r = $q->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
//            return $r;
//        }
//        return $entity;
    }

    public function Delete($id, $extra = null)
    {
//        $this->getEntityManager()->remove($this->find($id));
//        $this->getEntityManager()->flush();
//        return $id;
    }

}

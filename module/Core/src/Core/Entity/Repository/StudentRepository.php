<?php

namespace Core\Entity\Repository;

use Core\Entity\Student;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * @author marten
 */
class StudentRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = new Student($this->getEntityManager());
        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);

        if ($returnPartial) {

            $dql = "
                    SELECT 
                        partial student.{
                            id,
                            firstName,
                            lastName,
                            code,
                            email
                        },
                        partial studentGroup.{
                            id
                        }
                    FROM Core\Entity\Student student
                    JOIN student.studentGroup studentGroup
                    WHERE student.id = " . $entity->getId() . "
                ";

            $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
            $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
            return $r;
        }

        return $entity;
    }

    public function Delete($id, $extra = null)
    {
        
    }

    public function Get($id, $returnPartial = false, $extra = null)
    {
        
    }

    public function GetList($params = null, $extra = null)
    {
        
    }


    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        ; //TODO
    }

}

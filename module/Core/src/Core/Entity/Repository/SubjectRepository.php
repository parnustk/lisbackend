<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity\Repository;

use Core\Entity\Subject;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'subject';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\Subject';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        code,
                        name,
                        durationAllAK,
                        durationContactAK,
                        durationIndependentAK,
                        trashed
                    },
                    partial module.{
                    id,
                    name
                    },
                    partial gradingType.{
                    id,
                    gradingType
                    }
                    FROM $this->baseEntity $this->baseAlias
                    JOIN $this->baseAlias.module module 
                    JOIN $this->baseAlias.gradingType gradingType";
    }
    
     private function validateModule($data)
    {
        if (!key_exists('module', $data)) {
            throw new Exception(
            Json::encode(
                    'Missing module for subject', true
            )
            );
        }

        if (!$data['module']) {
            throw new Exception(
            Json::encode(
                    'Missing module for subject', true
            )
            );
        }
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
                new Subject($this->getEntityManager()), $data
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
        $this->validateModule($data);
        $entity = $this->find($id);
        
        $module = $this->getEntityManager()
                ->getRepository('Core\Entity\Module')
                ->find($data['module']);

        $entity->setModule($module);

        unset($data['module']);

        $entity->hydrate($data);
        
        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        //manytomany validate manually
        if (!count($entity->getgradingType())) {
            throw new Exception(Json::encode('Missing gradingType for subject', true));
        }
        return $this->singleResult($entity, $returnPartial, $extra);
    }

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return Subject
     * @throws Exception
     */
//    public function Create($data, $returnPartial = false, $extra = null)
//    {
//        $entity = new Subject($this->getEntityManager());
//
//        $entity->hydrate($data);
//
//        if (!$entity->validate()) {
//            throw new Exception(Json::encode($entity->getMessages(), true));
//        }
//
//        //manytomany validate manually
//        if (!count($entity->getGradingType())) {
//            throw new Exception(Json::encode('Missing gradingType', true));
//        }
//
//        $this->getEntityManager()->persist($entity);
//        $this->getEntityManager()->flush($entity);
//
//        if ($returnPartial) {
//
//            $dql = "
//                    SELECT 
//                        partial s.{id,code,name,durationAllAK,durationContactAK,durationIndependentAK},
//                        partial module.{id,name},
//                        partial gradingType.{id,gradingType}
//                    FROM Core\Entity\Subject s
//                    JOIN s.module module 
//                    JOIN s.gradingType gradingType
//                    WHERE s.id = " . $entity->getId();
//
//            try {
//                $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
//                $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
//            } catch (Exception $exc) {
//                throw new Exception($exc->getTraceAsString());
//            }
//
//            return $r;
//        }
//        return $entity;
//    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
//    public function Update($id, $data, $returnPartial = false, $extra = null)
//    {
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
//
//            $dql = "SELECT 
//                        partial s.{id,code,name,durationAllAK,durationContactAK,durationIndependentAK},
//                        partial module.{id,name},
//                        partial gradingType.{id,gradingType}
//                    FROM Core\Entity\Subject s
//                    JOIN s.module module 
//                    JOIN s.gradingType gradingType
//                    WHERE s.id = " . $id;
//
//            try {
//                $q = $this->getEntityManager()->createQuery($dql); //print_r($q->getSQL());
//                $r = $q->getSingleResult(Query::HYDRATE_ARRAY);
//            } catch (Exception $exc) {
//                throw new Exception($exc->getTraceAsString());
//            }
//
//            return $r;
//        }
//        return $entity;
//    }

}

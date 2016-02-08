<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Core\Entity\SubjectRound;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRoundRepository extends AbstractBaseRepository
{
    /**
     *
     * @var string
     */
    protected $baseAlias = 'subjectround';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\SubjectRound';
    
    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        trashed
                    },
                    partial subject.{
                            id
                    },
                    partial studentGroup.{
                            id
                    },
                    partial teacher.{
                            id
                    }
                FROM $this->baseEntity $this->baseAlias
                JOIN $this->baseAlias.teacher teacher
                JOIN $this->baseAlias.subject subject
                JOIN $this->baseAlias.studentGroup studentGroup";
    }
    
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new SubjectRound($this->getEntityManager()), $data
        );
        //IF required MANY TO MANY validate manually
        if (!count($entity->getTeacher())) {
            throw new Exception(Json::encode('Missing teachers for contact lesson', true));
        }
        return $this->singleResult($entity, $returnPartial, $extra);
    }
    
    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return type
     * @throws Exception
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                $this->find($id), $data
        );
        return $this->singleResult($entity, $returnPartial, $extra);
    }
    
}

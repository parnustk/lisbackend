<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Core\Entity\Teacher;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * @author Juhan Kõks <juhankoks@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class TeacherRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'teacher';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\Teacher';

    protected function dqlStart()
    {
        $dql = "SELECT
                    partial $this->baseAlias.{
                     id,
                     firstName,
                     lastName,
                     personalCode,
                     email,
                     trashed
                }
                FROM $this->baseEntity $this->baseAlias";
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
                new Teacher($this->getEntityManager()), $data
        );
        return $this->singleResult($entity, $returnPartial, $extra);
    }

    /**
     * 
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
        return $this->singleResult($entity, $returnPartial, $extra);
    }

}

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Entity\Repository;

use Core\Entity\Absence;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Exception;
use Zend\Json\Json;
use Doctrine\ORM\Query;

/**
 * AbsenceRepository
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceRepository extends EntityRepository implements CRUD
{

    /**
     * 
     * @param stdClass $params
     * @param mixed $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null)
    {
        if ($params) {
            //todo if neccessary
        }
        $dql = "SELECT partial absence.{id},
                       partial absencereason.{id},
                       partial student.{id},
                       partial contactLesson{id}
                FROM Core\Entity\Absence absence
                WHERE absence.trashed IS NULL";
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
     * {@inheritDoc}
     */
    public function Get($id, $returnPartial = false, $extra = null)
    {
        
    }

    /**
     * {@inheritDoc}
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        
    }

    /**
     * {@inheritDoc}
     */
    public function Update($id, $data, $returnPartial = false, $extra = null)
    {
        
    }

    /**
     * {@inheritDoc}
     */
    public function Delete($id, $extra = null)
    {
        
    }

}

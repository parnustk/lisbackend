<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * @author    Arnold Tserepov <tserepov@gmail.com>
 */
namespace Core\Entity\Repository;

use Core\Entity\GradeChoice;

class GradeChoiceRepository extends AbstractBaseRepository
{

    /*
     * @var string
     */
    protected $baseAlias = 'gradechoice';
    
    /*
     * @var string
     */
    protected $baseEntity = 'Core\Entity\GradeChoice';
    
    /*
     * @return string
     */
    
    protected function dqlStart()
    {
        $dql =  "SELECT
                    partial $this->baseAlias.{
                     id,
                     name
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
                new GradeChoice($this->getEntityManager()), $data
                );
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
        $entity = $this->validateEntity(
                $this->find($id), $data
        );
        return $this->singleResult($entity, $returnPartial, $extra);
    } 

}

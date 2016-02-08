<?php

namespace Core\Entity\Repository;

use Core\Entity\GradingType;
use Exception;


/**
 * @author sander, Alar Aasa <alar@alaraasa.ee>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class GradingTypeRepository extends AbstractBaseRepository
{
    /*
     * @var string
     */
    protected $baseAlias = 'gradingtype';
    
    /*
     * @var string
     */
    protected $baseEntity = 'Core\Entity\GradingType';
    
    /*
     * @return string
     */
    protected function dqlStart(){
        $dql = "SELECT 
                    partial $this->baseAlias.{
                        id,
                        gradingType,
                        trashed
                    }
                    FROM $this->baseEntity $this->baseAlias";
        return $dql;
            
    }
    
    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param type $extra
     * @return GradingType
     * @throws Exception
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new GradingType($this->getEntityManager()), $data
                );
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

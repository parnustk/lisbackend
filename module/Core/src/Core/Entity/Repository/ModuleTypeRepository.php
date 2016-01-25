<?php

namespace Core\Entity\Repository;

use Core\Entity\ModuleType;


/**
 * @author sander, Alar Aasa <alar@alaraasa.ee>
 */
class ModuleTypeRepository extends AbstractBaseRepository
{

    /*
     * @var string
     */
    protected $baseAlias = 'mt';
    
    /*
     * @var string
     */
    protected $baseEntity = 'Core\Entity\ModuleType';
            
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
     * @param type $data
     * @param type $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     * 
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new ModuleType($this->getEntityManager()), $data
                );
                //IF required MANY TO MANY validate manually
                return $this->singleResult($entity, $returnPartial, $extra);
    }

    

    /**
     * 
     * @param type $id
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
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entity, $returnPartial, $extra);
    } 

    
}

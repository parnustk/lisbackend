<?php

namespace Core\Entity\Repository;

use Core\Entity\ModuleType;


/**
 * @author Sander Mets <sandermets0@gmail.com>, Alar Aasa <alar@alaraasa.ee>, Eleri Apsolon <eleri.apsolon@gmail.com>
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
                     name,
                     trashed
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
        //IF required MANY TO MANY validate manually
        return $this->singleResult($entity, $returnPartial, $extra);
    } 

    
}

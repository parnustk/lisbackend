<?php

namespace Core\Entity\Repository;

use Core\Entity\Rooms;


/**
 * RoomsRepository
 *
 * @author Alar Aasa <alar@alaraasa.ee>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class RoomsRepository extends AbstractBaseRepository
{

    /*
     * @var string
     */
    protected $baseAlias = 'room';
    
    /*
     * @var string
     */
    protected $baseEntity = 'Core\Entity\Rooms';
    
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
     * @param array $data
     * @param bool|null $returnPartial
     * @param stdClass|null $extra
     * @return mixed
     */
    public function Create($data, $returnPartial = false, $extra = null)
    {
        $entity = $this->validateEntity(
                new Rooms($this->getEntityManager()), $data
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

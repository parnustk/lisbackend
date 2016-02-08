<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Entity\Repository;

use Core\Entity\Module;
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
class ModuleRepository extends AbstractBaseRepository
{

    /**
     *
     * @var string
     */
    protected $baseAlias = 'module';

    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\Module';

    /**
     * 
     * @return string
     */
    protected function dqlStart()
    {
        return "SELECT 
                    partial $this->baseAlias.{
                        id,
                        name,
                        duration,
                        code,
                        trashed
                    },
                    partial vocation.{
                    id
                    },
                    partial moduleType.{
                    id
                    },
                    partial gradingType.{
                    id
                    }
                    FROM $this->baseEntity $this->baseAlias
                    JOIN $this->baseAlias.vocation vocation
                    JOIN $this->baseAlias.moduleType moduleType 
                    JOIN $this->baseAlias.gradingType gradingType";
    }

    private function validateVocation($data)
    {
        if (!key_exists('vocation', $data)) {
            throw new Exception(
            Json::encode(
                    'Missing vocation for module', true
            )
            );
        }

        if (!$data['vocation']) {
            throw new Exception(
            Json::encode(
                    'Missing vocation for module', true
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
                new Module($this->getEntityManager()), $data
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
        $this->validateVocation($data);
        $entity = $this->find($id);

        $vocation = $this->getEntityManager()
                ->getRepository('Core\Entity\Vocation')
                ->find($data['vocation']);

        $entity->setVocation($vocation);

        unset($data['vocation']);

        $entity->hydrate($data);

        if (!$entity->validate()) {
            throw new Exception(Json::encode($entity->getMessages(), true));
        }
        //manytomany validate manually
        if (!count($entity->getgradingType())) {
            throw new Exception(Json::encode('Missing gradingType for module', true));
        }
        return $this->singleResult($entity, $returnPartial, $extra);
    }

}

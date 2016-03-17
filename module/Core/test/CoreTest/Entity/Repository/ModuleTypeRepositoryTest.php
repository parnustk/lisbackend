<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\ModuleTypeRepository;
use Exception;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleTypeRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * 
     */
    public function setUp()
    {
        $mockEntityManager = $this
                ->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();

        $mockClassMetadata = $this
                ->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
                ->disableOriginalConstructor()
                ->getMock();

        $repository = new ModuleTypeRepository($mockEntityManager, $mockClassMetadata);
        $this->moduleTypeRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\ModuleTypeRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->moduleTypeRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleTypeRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->moduleTypeRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleTypeRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->moduleTypeRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleTypeRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->moduleTypeRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleTypeRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->moduleTypeRepository->GetList(1);
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }

}

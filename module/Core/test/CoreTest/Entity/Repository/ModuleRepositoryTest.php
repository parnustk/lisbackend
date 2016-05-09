<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity\Repository;

use Core\Entity\Repository\ModuleRepository;
use Exception;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * setting up object for testing
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

        $repository = new ModuleRepository($mockEntityManager, $mockClassMetadata);
        $this->moduleRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\ModuleRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->moduleRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('"Missing vocation for module"', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->moduleRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->moduleRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->moduleRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ModuleRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->moduleRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

}

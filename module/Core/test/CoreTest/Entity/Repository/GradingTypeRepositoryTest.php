<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\GradingTypeRepository;
use Exception;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class GradingTypeRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new GradingTypeRepository($mockEntityManager, $mockClassMetadata);
        $this->gradingTypeRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\GradingTypeRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->gradingTypeRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradingTypeRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->gradingTypeRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradingTypeRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->gradingTypeRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradingTypeRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->gradingTypeRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradingTypeRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->gradingTypeRepository->GetList(1);
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }

}

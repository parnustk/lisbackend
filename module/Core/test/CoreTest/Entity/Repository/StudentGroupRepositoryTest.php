<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\StudentGroupRepository;
use Exception;

/**
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class StudentGroupRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new StudentGroupRepository($mockEntityManager, $mockClassMetadata);
        $this->studentGroupRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\StudentGroupRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->studentGroupRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGroupRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->studentGroupRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGroupRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->studentGroupRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGroupRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->studentGroupRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGroupRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->studentGroupRepository->GetList(1);
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }

}




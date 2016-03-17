<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity\Repository;

use Core\Entity\Repository\StudentGradeRepository;
use Exception;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentGradeRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new StudentGradeRepository($mockEntityManager, $mockClassMetadata);
        $this->studentGradeRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\StudentGradeRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->studentGradeRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGradeRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->studentGradeRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGradeRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->studentGradeRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGradeRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->studentGradeRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\StudentGradeRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->studentGradeRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

}

<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\GradeChoiceRepository;
use Exception;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class GradeChoiceRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new GradeChoiceRepository($mockEntityManager, $mockClassMetadata);
        $this->gradeChoiceRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\GradeChoiceRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->gradeChoiceRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradeChoiceRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->gradeChoiceRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradeChoiceRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->gradeChoiceRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradeChoiceRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->gradeChoiceRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\GradeChoiceRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->gradeChoiceRepository->GetList(1);
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }

}

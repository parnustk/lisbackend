<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity\Repository;

use Core\Entity\Repository\AbsenceReasonRepository;
use Exception;

/**
 * Description of AbsenceReasonRepositoryTest
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class AbsenceReasonRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * setting up an object to testing
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

        $repository = new AbsenceReasonRepository($mockEntityManager, $mockClassMetadata);
        $this->absenceReasonRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\AbsenceReasonRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->absenceReasonRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals("NO_DATA", $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\AbsenceReasonRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->absenceReasonRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\AbsenceReasonRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->absenceReasonRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\AbsenceReasonRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->absenceReasonRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\AbsenceReasonRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->absenceReasonRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

}

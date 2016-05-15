<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\SubjectRoundRepository;
use Exception;

/**
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class SubjectRoundRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new SubjectRoundRepository($mockEntityManager, $mockClassMetadata);
        $this->subjectRoundRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\SubjectRoundRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->subjectRoundRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRoundRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->subjectRoundRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRoundRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->subjectRoundRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRoundRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->subjectRoundRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRoundRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->subjectRoundRepository->GetList(1);
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }

}




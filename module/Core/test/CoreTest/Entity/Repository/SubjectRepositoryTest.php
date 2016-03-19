<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\SubjectRepository;
use Exception;

/**
 * Description of SubjectRepositoryTest
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class SubjectRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new SubjectRepository($mockEntityManager, $mockClassMetadata);
        $this->subjectRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\SubjectRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->subjectRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('NO_DATA', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->subjectRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->subjectRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->subjectRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\SubjectRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->subjectRepository->GetList(1);
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }

}

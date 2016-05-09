<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity\Repository;

use Core\Entity\Repository\ContactLessonRepository;
use Exception;

/**
 * Description of ContactLessonRepositoryTest
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class ContactLessonRepositoryTest extends \PHPUnit_Framework_TestCase
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

        $repository = new ContactLessonRepository($mockEntityManager, $mockClassMetadata);
        $this->contactLessonRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\ContactLessonRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->contactLessonRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals('"Missing subject round for contact lesson"', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ContactLessonRepository::Update()
     */
    public function testUpdate()
    {
        try {
            $this->contactLessonRepository->Update(1, []);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ContactLessonRepository::Delete()
     */
    public function testDelete()
    {
        try {
            $this->contactLessonRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ContactLessonRepository::Get()
     */
    public function testGet()
    {
        try {
            $this->contactLessonRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\ContactLessonRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->contactLessonRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }

}

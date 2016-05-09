<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\StudentInGroups;
use DateTime;

/**
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class StudentInGroupsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\StudentInGroups
     */
    protected $studentInGroups;

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $mockEntityManager;

    /**
     * 
     */
    public function setUp()
    {
        $this->mockEntityManager = $this
                ->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();

        $studentInGroups = new StudentInGroups($this->mockEntityManager);
        $this->studentInGroups = $studentInGroups;
    }

    /**
     * @covers Core\Entity\StudentGroup::setId
     * @covers Core\Entity\StudentGroup::getId
     */
    public function testSetGetId()
    {
        $this->studentInGroups->setId(1);
        $this->assertEquals(1, $this->studentInGroups->getId());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setStudent
     * @covers Core\Entity\StudentInGroups::getStudent
     */
    public function testSetGetStudent()
    {
        $mockStudent = $this
                ->getMockBuilder('Core\Entity\Student')
                ->getMock();
        
        $this->studentInGroups->setStudent($mockStudent);
        $this->assertEquals($mockStudent, $this->studentInGroups->getStudent());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setStudentGroup
     * @covers Core\Entity\StudentInGroups::getStudentGroup
     */
    public function testSetGetStudentGroup()
    {
        $mockStudentGroup = $this
                ->getMockBuilder('Core\Entity\StudentGroup')
                ->getMock();

        $this->studentInGroups->setStudentGroup($mockStudentGroup);
        $this->assertEquals($mockStudentGroup, $this->studentInGroups->getStudentGroup());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setStatus
     * @covers Core\Entity\StudentInGroups::getStatus
     */
    public function testSetGetStatus()
    {
        $statusInt = 1;
        $this->studentInGroups->setStatus($statusInt);
        $this->assertEquals($statusInt, $this->studentInGroups->getStatus());
        
        $statusString = "Hello";
        $this->studentInGroups->setStatus($statusString);
        $this->assertNotEquals($statusString, $this->studentInGroups->getStatus());
    }
    
    /**
     * @covers Core\Entity\StudentInGroups::setNotes
     * @covers Core\Entity\StudentInGroups::getNotes
     */
    public function testSetGetNotes()
    {
        $notes = 'These are the notes for this test';
        $this->studentInGroups->setNotes($notes);
        $this->assertEquals($notes, $this->studentInGroups->getNotes());
    }
    /**
     * @covers Core\Entity\StudentInGroups::setTrashed
     * @covers Core\Entity\StudentInGroups::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->studentInGroups->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->studentInGroups->getTrashed());

        $trashedString = "A";
        $this->studentInGroups->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->studentInGroups->getTrashed());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setCreatedBy
     * @covers Core\Entity\StudentInGroups::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->studentInGroups->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->studentInGroups->getCreatedBy());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setUpdatedBy
     * @covers Core\Entity\StudentInGroups::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->studentInGroups->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->studentInGroups->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setCreatedAt
     * @covers Core\Entity\StudentInGroups::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->studentInGroups->setCreatedAt($dt);
        $this->assertEquals($dt, $this->studentInGroups->getCreatedAt());
    }

    /**
     * @covers Core\Entity\StudentInGroups::setUpdatedAt
     * @covers Core\Entity\StudentInGroups::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->studentInGroups->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->studentInGroups->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\StudentInGroups::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $studentInGroups = new StudentInGroups($this->mockEntityManager);

        $studentInGroups->refreshTimeStamps();
        $createdAt = $studentInGroups->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($studentInGroups->getUpdatedAt());

        $studentInGroups->refreshTimeStamps();
        $updatedAt = $studentInGroups->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $studentInGroups->getCreatedAt());
    }

}

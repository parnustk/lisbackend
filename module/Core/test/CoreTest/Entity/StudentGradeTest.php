<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\StudentGrade;
use DateTime;

/**
 * Description of StudentGroupTest
 * 
 * @author Marten Kähr <marten@kahr.ee>
 */
class StudentGradeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Core\Entity\StudentGrade
     */
    protected $studentGrade;
    
    /**
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
        
        $studentGrade = new StudentGrade($this->mockEntityManager);
        $this->studentGrade = $studentGrade;
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setId
     * @covers Core\Entity\StudentGrade::getId
     */
    public function testSetGetId()
    {
        $this->studentGrade->setId(1);
        $this->assertEquals(1, $this->studentGrade->getId());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setNotes
     * @covers Core\Entity\StudentGrade::getNotes
     */
    public function testSetGetNotes()
    {
        $this->studentGrade->setNotes("Notes");
        $this->assertEquals("Notes", $this->studentGrade->getNotes());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setStudent
     * @covers Core\Entity\StudentGrade::getStudent
     */
    public function testSetGetStudent()
    {
        $mockStudent = $this
                ->getMockBuilder('Core\Entity\Student')
                ->getMock();
        $this->studentGrade->setStudent($mockStudent);
        $this->assertEquals($mockStudent, $this->studentGrade->getStudent());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setGradeChoice
     * @covers Core\Entity\StudentGrade::getGradeChoice
     */
    public function testSetGetGradeChoice()
    {
        $mockGradeChoice = $this
                ->getMockBuilder('Core\Entity\GradeChoice')
                ->getMock();
        $this->studentGrade->setGradeChoice($mockGradeChoice);
        $this->assertEquals($mockGradeChoice, $this->studentGrade->getGradeChoice());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setTeacher
     * @covers Core\Entity\StudentGrade::getTeacher
     */
    public function testSetGetTeacher()
    {
        $mockTeacher = $this
                ->getMockBuilder('Core\Entity\Teacher')
                ->getMock();
        $this->studentGrade->setTeacher($mockTeacher);
        $this->assertEquals($mockTeacher, $this->studentGrade->getTeacher());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setIndependentWork
     * @covers Core\Entity\StudentGrade::getIndependentWork
     */
    public function testSetGetIndependentWork()
    {
        $mockIndependentWork = $this
                ->getMockBuilder('Core\Entity\IndependentWork')
                ->getMock();
        $this->studentGrade->setIndependentWork($mockIndependentWork);
        $this->assertEquals($mockIndependentWork, $this->studentGrade->getIndependentWork());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setModule
     * @covers Core\Entity\StudentGrade::getModule
     */
    public function testSetGetModule()
    {
        $mockModule = $this
                ->getMockBuilder('Core\Entity\Module')
                ->getMock();
        $this->studentGrade->setModule($mockModule);
        $this->assertEquals($mockModule, $this->studentGrade->getModule());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setSubjectRound
     * @covers Core\Entity\StudentGrade::getSubjectRound
     */
    public function testSetGetSubjectRound()
    {
        $mockSubjectRound = $this
                ->getMockBuilder('Core\Entity\SubjectRound')
                ->getMock();
        $this->studentGrade->setSubjectRound($mockSubjectRound);
        $this->assertEquals($mockSubjectRound, $this->studentGrade->getSubjectRound());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setContactLesson
     * @covers Core\Entity\StudentGrade::getContactLesson
     */
    public function testSetGetContactLesson()
    {
        $mockContactLesson = $this
                ->getMockBuilder('Core\Entity\ContactLesson')
                ->getMock();
        $this->studentGrade->setContactLesson($mockContactLesson);
        $this->assertEquals($mockContactLesson, $this->studentGrade->getContactLesson());
    }
    
    /**
     * @covers Core\Entity\StudentGrade::setTrashed
     * @covers Core\Entity\StudentGrade::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->studentGrade->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->studentGrade->getTrashed());

        $trashedString = "A";
        $this->studentGrade->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->studentGrade->getTrashed());
    }

    /**
     * @covers Core\Entity\StudentGrade::setCreatedBy
     * @covers Core\Entity\StudentGrade::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->studentGrade->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->studentGrade->getCreatedBy());
    }

    /**
     * @covers Core\Entity\StudentGrade::setUpdatedBy
     * @covers Core\Entity\StudentGrade::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->studentGrade->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->studentGrade->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\StudentGrade::setCreatedAt
     * @covers Core\Entity\StudentGrade::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->studentGrade->setCreatedAt($dt);
        $this->assertEquals($dt, $this->studentGrade->getCreatedAt());
    }

    /**
     * @covers Core\Entity\StudentGrade::setUpdatedAt
     * @covers Core\Entity\StudentGrade::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->studentGrade->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->studentGrade->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\StudentGrade::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $studentGrade = new StudentGrade($this->mockEntityManager);

        $studentGrade->refreshTimeStamps();
        $createdAt = $studentGrade->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($studentGrade->getUpdatedAt());

        $studentGrade->refreshTimeStamps();
        $updatedAt = $studentGrade->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $studentGrade->getCreatedAt());
    }
}
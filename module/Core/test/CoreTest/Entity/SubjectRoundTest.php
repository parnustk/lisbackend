<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\SubjectRound;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRoundTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\SubjectRound 
     */
    protected $subjectRound;

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

        $subjectRound = new SubjectRound($this->mockEntityManager);
        $this->subjectRound = $subjectRound;
    }

    /**
     * @covers Core\Entity\SubjectRound::setId
     * @covers Core\Entity\SubjectRound::getId
     */
    public function testSetGetId()
    {
        $this->subjectRound->setId(1);
        $this->assertEquals(1, $this->subjectRound->getId());
    }
    
    /**
     * @covers Core\Entity\SubjectRound::setIndependentWork
     * @covers Core\Entity\SubjectRound::getIndependentWork
     */
    public function testSetGetIndependentWork()
    {
        $mockIndependentWork = $this
                ->getMockBuilder('Core\Entity\IndependentWork')
                ->getMock();

        $this->subjectRound->setIndependentWork($mockIndependentWork);
        $this->assertEquals($mockIndependentWork, $this->subjectRound->getIndependentWork());
    }
    
    /**
     * @covers Core\Entity\SubjectRound::setContactLesson
     * @covers Core\Entity\SubjectRound::getContactLesson
     */
    public function testSetGetContactLesson()
    {
        $mockContactLesson = $this
                ->getMockBuilder('Core\Entity\ContactLesson')
                ->getMock();

        $this->subjectRound->setContactLesson($mockContactLesson);
        $this->assertEquals($mockContactLesson, $this->subjectRound->getContactLesson());
    }

    /**
     * @covers Core\Entity\SubjectRound::setStudentGrade
     * @covers Core\Entity\SubjectRound::getStudentGrade
     */
    public function testSetGetStudentGrade()
    {
        $mockStudentGrade = $this
                ->getMockBuilder('Core\Entity\StudentGrade')
                ->getMock();

        $this->subjectRound->setStudentGrade($mockStudentGrade);
        $this->assertEquals($mockStudentGrade, $this->subjectRound->getStudentGrade());
    }

    /**
     * @covers Core\Entity\SubjectRound::setSubject
     * @covers Core\Entity\SubjectRound::getSubject
     */
    public function testSetGetSubject()
    {
        $mockSubject = $this
                ->getMockBuilder('Core\Entity\Subject')
                ->getMock();

        $this->subjectRound->setSubject($mockSubject);
        $this->assertEquals($mockSubject, $this->subjectRound->getSubject());
    }
    
    /**
     * @covers Core\Entity\SubjectRound::setStudentGroup
     * @covers Core\Entity\SubjectRound::getStudentGroup
     */
    public function testSetGetStudentGroup()
    {
        $mockStudentGroup = $this
                ->getMockBuilder('Core\Entity\StudentGroup')
                ->getMock();

        $this->subjectRound->setStudentGroup($mockStudentGroup);
        $this->assertEquals($mockStudentGroup, $this->subjectRound->getStudentGroup());
    }

    /**
     * @covers Core\Entity\SubjectRound::setTeacher
     * @covers Core\Entity\SubjectRound::getTeacher
     */
    public function testSetGetTeacher()
    {
        $mockTeacher = $this
                ->getMockBuilder('Core\Entity\Teacher')
                ->getMock();

        $this->subjectRound->setTeacher($mockTeacher);
        $this->assertEquals($mockTeacher, $this->subjectRound->getTeacher());
    }

    /**
     * @covers Core\Entity\SubjectRound::setTrashed
     * @covers Core\Entity\SubjectRound::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->subjectRound->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->subjectRound->getTrashed());

        $trashedString = "A";
        $this->subjectRound->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->subjectRound->getTrashed());
    }

    /**
     * @covers Core\Entity\SubjectRound::setCreatedBy
     * @covers Core\Entity\SubjectRound::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->subjectRound->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->subjectRound->getCreatedBy());
    }

    /**
     * @covers Core\Entity\SubjectRound::setUpdatedBy
     * @covers Core\Entity\SubjectRound::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->subjectRound->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->subjectRound->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\SubjectRound::setCreatedAt
     * @covers Core\Entity\SubjectRound::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->subjectRound->setCreatedAt($dt);
        $this->assertEquals($dt, $this->subjectRound->getCreatedAt());
    }

    /**
     * @covers Core\Entity\SubjectRound::setUpdatedAt
     * @covers Core\Entity\SubjectRound::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->subjectRound->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->subjectRound->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\SubjectRound::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $subjectRound = new SubjectRound($this->mockEntityManager);

        $subjectRound->refreshTimeStamps();
        $createdAt = $subjectRound->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($subjectRound->getUpdatedAt());

        $subjectRound->refreshTimeStamps();
        $updatedAt = $subjectRound->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $subjectRound->getCreatedAt());
    }

}

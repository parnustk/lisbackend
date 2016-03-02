<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\ContactLesson;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ContactLessonTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Module 
     */
    protected $contactLesson;

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

        $contactLesson = new ContactLesson($this->mockEntityManager);
        $this->contactLesson = $contactLesson;
    }

    /**
     * @covers Core\Entity\ContactLesson::setId
     * @covers Core\Entity\ContactLesson::getId
     */
    public function testSetGetId()
    {
        $this->contactLesson->setId(1);
        $this->assertEquals(1, $this->contactLesson->getId());
    }

    /**
     * @covers Core\Entity\ContactLesson::setLessonDate
     * @covers Core\Entity\ContactLesson::getLessonDate
     */
    public function testSetGetLessonDate()
    {
        $lessonDate = new \DateTime;
        $this->contactLesson->setLessonDate($lessonDate);
        $this->assertEquals($lessonDate, $this->contactLesson->getLessonDate());
    }
    
    /**
     * @covers Core\Entity\ContactLesson::setLessonDescription
     * @covers Core\Entity\ContactLesson::getLessonDescription
     */
    public function testSetGetDescription()
    {
        $lessonDescription = 'Description';
        $this->contactLesson->setDescription($lessonDescription);
        $this->assertEquals($lessonDescription, $this->contactLesson->getDescription());
    }

    /**
     * @covers Core\Entity\ContactLesson::setDurationAK
     * @covers Core\Entity\ContactLesson::getDurationAK
     */
    public function testSetGetDurationAK()
    {
        $duration = '85';
        $this->contactLesson->setDurationAK($duration);
        $this->assertEquals($duration, $this->contactLesson->getDurationAK());
    }
    
    /**
     * @covers Core\Entity\ContactLesson::setAbsence
     * @covers Core\Entity\ContactLesson::getAbsence
     */
    public function testSetGetAbsence()
    {
        $mockAbsence = $this
                ->getMockBuilder('Core\Entity\Absence')
                ->getMock();

        $this->contactLesson->setAbsence($mockAbsence);
        $this->assertEquals($mockAbsence, $this->contactLesson->getAbsence());
    }

    /**
     * @covers Core\Entity\ContactLesson::setRoom
     * @covers Core\Entity\ContactLesson::getRoom
     */
    public function testSetGetRooms()
    {
        $mockRoom = $this
                ->getMockBuilder('Core\Entity\Rooms')
                ->getMock();

        $this->contactLesson->setRooms($mockRoom);
        $this->assertEquals($mockRoom, $this->contactLesson->getRooms());
    }

    /**
     * @covers Core\Entity\ContactLesson::setStudentGrade
     * @covers Core\Entity\ContactLesson::getStudentGrade
     */
    public function testSetGetStudentGrade()
    {
        $mockStudentGrade = $this
                ->getMockBuilder('Core\Entity\StudentGrade')
                ->getMock();

        $this->contactLesson->setStudentGrade($mockStudentGrade);
        $this->assertEquals($mockStudentGrade, $this->contactLesson->getStudentGrade());
    }

    /**
     * @covers Core\Entity\ContactLesson::setSubjectRound
     * @covers Core\Entity\ContactLesson::getSubjectRound
     */
    public function testSetGetSubjectRound()
    {
        $mockSubjectRound = $this
                ->getMockBuilder('Core\Entity\SubjectRound')
                ->getMock();

        $this->contactLesson->setSubjectRound($mockSubjectRound);
        $this->assertEquals($mockSubjectRound, $this->contactLesson->getSubjectRound());
    }

    /**
     * @covers Core\Entity\ContactLesson::setTeacher
     * @covers Core\Entity\ContactLesson::getTeacher
     */
    public function testSetGetTeacher()
    {
        $mockTeacher = $this
                ->getMockBuilder('Core\Entity\Teacher')
                ->getMock();

        $this->contactLesson->setTeacher($mockTeacher);
        $this->assertEquals($mockTeacher, $this->contactLesson->getTeacher());
    }

    /**
     * @covers Core\Entity\ContactLesson::setTrashed
     * @covers Core\Entity\ContactLesson::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->contactLesson->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->contactLesson->getTrashed());

        $trashedString = "A";
        $this->contactLesson->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->contactLesson->getTrashed());
    }

    /**
     * @covers Core\Entity\ContactLesson::setCreatedBy
     * @covers Core\Entity\ContactLesson::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->contactLesson->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->contactLesson->getCreatedBy());
    }

    /**
     * @covers Core\Entity\ContactLesson::setUpdatedBy
     * @covers Core\Entity\ContactLesson::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->contactLesson->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->contactLesson->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\ContactLesson::setCreatedAt
     * @covers Core\Entity\ContactLesson::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->contactLesson->setCreatedAt($dt);
        $this->assertEquals($dt, $this->contactLesson->getCreatedAt());
    }

    /**
     * @covers Core\Entity\ContactLesson::setUpdatedAt
     * @covers Core\Entity\ContactLesson::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->contactLesson->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->contactLesson->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\ContactLesson::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $contactLesson = new ContactLesson($this->mockEntityManager);

        $contactLesson->refreshTimeStamps();
        $createdAt = $contactLesson->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($contactLesson->getUpdatedAt());

        $contactLesson->refreshTimeStamps();
        $updatedAt = $contactLesson->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $contactLesson->getCreatedAt());
    }

}

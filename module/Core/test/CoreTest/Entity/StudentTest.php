<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Student;
use DateTime;

/**
 * Description of StudentTest
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class StudentTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Student
     */
    protected $student;

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

        $student = new Student($this->mockEntityManager);
        $this->student = $student;
    }

    /**
     * @covers Core\Entity\Student::setId
     * @covers Core\Entity\Student::getId
     */
    public function testSetGetId()
    {
        $this->student->setId(1);
        $this->assertEquals(1, $this->student->getId());
    }

    /**
     * @covers Core\Entity\Student::setFirstName
     * @covers Core\Entity\Student::getFirstName
     */
    public function testSetGetFirstName()
    {
        $firstName = "FirstName";
        $this->student->setFirstName($firstName);
        $this->assertEquals($firstName, $this->student->getFirstName());
    }

    /**
     * @covers Core\Entity\Student::setLastName
     * @covers Core\Entity\Student::getLastName
     */
    public function testSetGetLastName()
    {
        $lastName = "LastName";
        $this->student->setLastName($lastName);
        $this->assertEquals($lastName, $this->student->getLastName());
    }

    /**
     * @covers Core\Entity\Student::setPersonalCode
     * @covers Core\Entity\Student::getPersonalCode
     */
    public function testSetGetPersonalCode()
    {
        $personalCode = "A011";
        $this->student->setPersonalCode($personalCode);
        $this->assertEquals($personalCode, $this->student->getPersonalCode());
    }

    /**
     * @covers Core\Entity\Student::setEmail
     * @covers Core\Entity\Student::getEmail
     */
    public function testSetGetEmail()
    {
        $email = "opilane@opilane.ee";
        $this->student->setEmail($email);
        $this->assertEquals($email, $this->student->getEmail());
    }

    /**
     * @covers Core\Entity\Student::setLisUser
     * @covers Core\Entity\Student::getLisUser
     */
    public function testSetGetLisUser()
    {
        $lisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();
        $this->student->setLisUser($lisUser);
        $this->assertEquals($lisUser, $this->student->getLisUser());
    }

    /**
     * @covers Core\Entity\Student::setAbsence
     * @covers Core\Entity\Student::getAbsence
     */
    public function testSetGetAbsence()
    {
        $absence = $this
                ->getMockBuilder('Core\Entity\Absence')
                ->getMock();
        $this->student->setAbsence($absence);
        $this->assertEquals($absence, $this->student->getAbsence());
    }

    /**
     * @covers Core\Entity\Student::setStudentGrade
     * @covers Core\Entity\Student::getStudentGrade
     */
    public function testSetGetStudentGrade()
    {
        $sg = $this
                ->getMockBuilder('Core\Entity\StudentGrade')
                ->getMock();
        $this->student->setStudentGrade($sg);
        $this->assertEquals($sg, $this->student->getStudentGrade());
    }

    /**
     * @covers Core\Entity\Student::setStudentInGroups
     * @covers Core\Entity\Student::getStudentInGroups
     */
    public function testSetGetStudentInGroups()
    {
        $sig = $this
                ->getMockBuilder('Core\Entity\StudentInGroups')
                ->getMock();
        $this->student->setStudentInGroups($sig);
        $this->assertEquals($sig, $this->student->getStudentInGroups());
    }

    /**
     * @covers Core\Entity\Student::setIndependentWork
     * @covers Core\Entity\Student::getIndependentWork
     */
    public function testSetGetIndependentWork()
    {
        $iw = $this
                ->getMockBuilder('Core\Entity\IndependentWork')
                ->getMock();
        $this->student->setIndependentWork($iw);
        $this->assertEquals($iw, $this->student->getIndependentWork());
    }

    /**
     * @covers Core\Entity\Student::setTrashed
     * @covers Core\Entity\Student::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->student->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->student->getTrashed());

        $trashedString = "A";
        $this->student->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->student->getTrashed());
    }

    /**
     * @covers Core\Entity\Student::setCreatedBy
     * @covers Core\Entity\Student:getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->student->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->student->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Student::setUpdatedBy
     * @covers Core\Entity\Student::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->student->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->student->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Student::setCreatedAt
     * @covers Core\Entity\Student::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->student->setCreatedAt($dt);
        $this->assertEquals($dt, $this->student->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Student::setUpdatedAt
     * @covers Core\Entity\Student::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->student->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->student->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\Student::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $student = new Student($this->mockEntityManager);

        $student->refreshTimeStamps();
        $createdAt = $student->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($student->getUpdatedAt());

        $student->refreshTimeStamps();
        $updatedAt = $student->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $student->getCreatedAt());
    }

}

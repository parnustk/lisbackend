<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Teacher;
use DateTime;

/**
 * Description of TeacherTest
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class TeacherTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Teacher 
     */
    protected $teacher;

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

        $teacher = new Teacher($this->mockEntityManager);
        $this->teacher = $teacher;
    }

    /**
     * @covers Core\Entity\Teacher::setId
     * @covers Core\Entity\Teacher::getId
     */
    public function testSetGetId()
    {
        $this->teacher->setId(1);
        $this->assertEquals(1, $this->teacher->getId());
    }

    /**
     * @covers Core\Entity\Teacher::setFirstName
     * @covers Core\Entity\Teacher::getFirstName
     */
    public function testSetGetFirstName()
    {
        $firstName = "FirstName";
        $this->teacher->setFirstName($firstName);
        $this->assertEquals($firstName, $this->teacher->getFirstName());
    }

    /**
     * @covers Core\Entity\Teacher::setLastName
     * @covers Core\Entity\Teacher::getLastName
     */
    public function testSetGetLastName()
    {
        $lastName = "LastName";
        $this->teacher->setLastName($lastName);
        $this->assertEquals($lastName, $this->teacher->getLastName());
    }

    /**
     * @covers Core\Entity\Teacher::setCreatedBy
     * @covers Core\Entity\Teacher:getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->teacher->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->teacher->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Teacher::setUpdatedBy
     * @covers Core\Entity\Teacher::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->teacher->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->teacher->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Teacher::setPersonalCode
     * @covers Core\Entity\Teacher::getPersonalCode
     */
    public function testSetGetPersonalCode()
    {
        $personalCode = "A011";
        $this->teacher->setPersonalCode($personalCode);
        $this->assertEquals($personalCode, $this->teacher->getPersonalCode());
    }

    /**
     * @covers Core\Entity\Teacher::setEmail
     * @covers Core\Entity\Teacher::getEmail
     */
    public function testSetGetEmail()
    {
        $email = "ops@ops.ee";
        $this->teacher->setEmail($email);
        $this->assertEquals($email, $this->teacher->getEmail());
    }

    /**
     * @covers Core\Entity\Teacher::setCreatedAt
     * @covers Core\Entity\Teacher::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->teacher->setCreatedAt($dt);
        $this->assertEquals($dt, $this->teacher->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Teacher::setLisUser
     * @covers Core\Entity\Teacher::getLisUser
     */
    public function testSetGetLisUser()
    {
        $lisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();
        $this->teacher->setLisUser($lisUser);
        $this->assertEquals($lisUser, $this->teacher->getLisUser());
    }

    /**
     * @covers Core\Entity\Teacher::setIndependentWork
     * @covers Core\Entity\Teacher::getIndependentWork
     */
    public function testSetGetIndependentWork()
    {
        $iw = $this->getMockBuilder('Core\Entity\IndependentWork')
                ->getMock();
        $this->teacher->setIndependentWork($iw);
        $this->assertEquals($iw, $this->teacher->getIndependentWork());
    }

    /**
     * @covers Core\Entity\Teacher::setSubjectRound
     * @covers Core\Entity\Teacher::getSubjectRound
     */
    public function testSetGetSubjectRound()
    {
        $sr = $this->getMockBuilder('Core\Entity\SubjectRound')
                ->getMock();
        $this->teacher->setSubjectRound($sr);
        $this->assertEquals($sr, $this->teacher->getSubjectRound());
    }

    /**
     * @covers Core\Entity\Teacher::setContactLesson
     * @covers Core\Entity\Teacher::getContactLesson
     */
    public function testSetGetContactLesson()
    {
        $cl = $this->getMockBuilder('Core\Entity\ContactLesson')
                ->getMock();
        $this->teacher->setContactLesson($cl);
        $this->assertEquals($cl, $this->teacher->getContactLesson());
    }

    /**
     * @covers Core\Entity\Teacher::setTrashed
     * @covers Core\Entity\Teacher::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->teacher->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->teacher->getTrashed());

        $trashedString = "A";
        $this->teacher->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->teacher->getTrashed());
    }

    /**
     * @covers Core\Entity\Teacher::setUpdatedAt
     * @covers Core\Entity\Teacher::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->teacher->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->teacher->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\Teacher::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $teacher = new Teacher($this->mockEntityManager);

        $teacher->refreshTimeStamps();
        $createdAt = $teacher->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($teacher->getUpdatedAt());

        $teacher->refreshTimeStamps();
        $updatedAt = $teacher->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $teacher->getCreatedAt());
    }

}

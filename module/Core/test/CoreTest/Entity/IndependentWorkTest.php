<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\IndependentWork;
use DateTime;

/**
 * Description of IndependentWork
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class IndependentWorkTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\IndependentWork 
     */
    protected $independentwork;

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

        $independentwork = new IndependentWork($this->mockEntityManager);
        $this->independentwork = $independentwork;
    }

    /**
     * @covers Core\Entity\IndependentWork::setId
     * @covers Core\Entity\IndependentWork::getId
     */
    public function testSetGetId()
    {
        $this->independentwork->setId(1);
        $this->assertEquals(1, $this->independentwork->getId());
    }

    /**
     * @covers Core\Entity\IndependentWork::DueDate
     * @covers Core\Entity\IndependentWork::DueDate
     */
    public function testSetGetDueDate()
    {
        $dt = new DateTime;
        $this->independentwork->setDueDate($dt);
        $this->assertEquals($dt, $this->independentwork->getDueDate());
    }

    /**
     * @covers Core\Entity\IndependentWork::Description
     * @covers Core\Entity\IndependentWork::Description
     */
    public function testSetGetDescription()
    {
        $desc = "Description";
        $this->independentwork->setDescription($desc);
        $this->assertEquals($desc, $this->independentwork->getDescription());
    }

    /**
     * @covers Core\Entity\IndependentWork::DurationAK
     * @covers Core\Entity\IndependentWork::DurationAK
     */
    public function testSetGetDurationAK()
    {
        $duration = 1;
        $this->independentwork->setDurationAK($duration);
        $this->assertEquals($duration, $this->independentwork->getDurationAK());
    }

    /**
     * @covers Core\Entity\IndependentWork::StudentGrade
     * @covers Core\Entity\IndependentWork::StudentGrade
     */
    public function testSetGetStudentGrade()
    {
        $sgrade = $this->getMockBuilder('Core\Entity\StudentGrade')
                ->getMock();
        $this->independentwork->setStudentGrade($sgrade);
        $this->assertEquals($this->independentwork->getStudentGrade(), $sgrade);
    }

    /**
     * @covers Core\Entity\IndependentWork::SubjectRound
     * @covers Core\Entity\IndependentWork::SubjectRound
     */
    public function testSetGetSubjectRound()
    {
        $sr = $this->getMockBuilder('Core\Entity\SubjectRound')
                ->getMock();
        $this->independentwork->setSubjectRound($sr);
        $this->assertEquals($this->independentwork->getSubjectRound(), $sr);
    }

    /**
     * @covers Core\Entity\IndependentWork::Teacher
     * @covers Core\Entity\IndependentWork::Teacher
     */
    public function testSetGetTeacher()
    {
        $teacher = $this->getMockBuilder('Core\Entity\Teacher')
                ->getMock();
        $this->independentwork->setTeacher($teacher);
        $this->assertEquals($this->independentwork->getTeacher(), $teacher);
    }

    /**
     * @covers Core\Entity\IndependentWork::Student
     * @covers Core\Entity\IndependentWork::Student
     */
    public function testSetGetStudent()
    {
        $student = $this->getMockBuilder('Core\Entity\Student')
                ->getMock();
        $this->independentwork->setStudent($student);
        $this->assertEquals($this->independentwork->getStudent(), $student);
    }

    /**
     * @covers Core\Entity\IndependentWork::setTrashed
     * @covers Core\Entity\IndependentWork:getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->independentwork->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->independentwork->getTrashed());

        $trashedString = "A";
        $this->independentwork->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->independentwork->getTrashed());
    }

    /**
     * @covers Core\Entity\IndependentWork::setCreatedBy
     * @covers Core\Entity\IndependentWork:getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->independentwork->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->independentwork->getCreatedBy());
    }

    /**
     * @covers Core\Entity\IndependentWork::setUpdatedBy
     * @covers Core\Entity\IndependentWork::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->independentwork->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->independentwork->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\IndependentWork::setCreatedAt
     * @covers Core\Entity\IndependentWork::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->independentwork->setCreatedAt($dt);
        $this->assertEquals($dt, $this->independentwork->getCreatedAt());
    }

    /**
     * @covers Core\Entity\IndependentWork::setUpdatedAt
     * @covers Core\Entity\IndependentWork::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->independentwork->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->independentwork->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\IndependentWork::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $independentwork = new IndependentWork($this->mockEntityManager);

        $independentwork->refreshTimeStamps();
        $createdAt = $independentwork->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($independentwork->getUpdatedAt());

        $independentwork->refreshTimeStamps();
        $updatedAt = $independentwork->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $independentwork->getCreatedAt());
    }

}

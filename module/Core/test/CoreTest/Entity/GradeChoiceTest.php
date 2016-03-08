<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\GradeChoice;
use DateTime;

/**
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class GradeChoiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\GradeChoice
     */
    protected $gradeChoice;

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

        $gradeChoice = new GradeChoice($this->mockEntityManager);
        $this->gradeChoice = $gradeChoice;
    }

    /**
     * @covers Core\Entity\GradeChoice::setId
     * @covers Core\Entity\GradeChoice::getId
     */
    public function testSetGetId()
    {
        $this->gradeChoice->setId(1);
        $this->assertEquals(1, $this->gradeChoice->getId());
    }

    /**
     * @covers Core\Entity\GradeChoice::setName
     * @covers Core\Entity\GradeChoice::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->gradeChoice->setName($name);
        $this->assertEquals($name, $this->gradeChoice->getName());
    }

    /**
     * @covers Core\Entity\GradeChoice::setStudentGrade
     * @covers Core\Entity\GradeChoice::getStudentGrade
     */
    public function testSetGetStudentGrade()
    {
        $mockStudentGrade = $this
                ->getMockBuilder('Core\Entity\StudentGrade')
                ->getMock();

        $this->gradeChoice->setStudentGrade($mockStudentGrade);
        $this->assertEquals($mockStudentGrade, $this->gradeChoice->getStudentGrade());
    }

    /**
     * @covers Core\Entity\GradeChoice::setTrashed
     * @covers Core\Entity\GradeChoice::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->gradeChoice->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->gradeChoice->getTrashed());

        $trashedString = "A";
        $this->gradeChoice->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->gradeChoice->getTrashed());
    }

    /**
     * @covers Core\Entity\GradeChoice::setCreatedBy
     * @covers Core\Entity\GradeChoice::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->gradeChoice->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->gradeChoice->getCreatedBy());
    }

    /**
     * @covers Core\Entity\GradeChoice::setUpdatedBy
     * @covers Core\Entity\GradeChoice::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->gradeChoice->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->gradeChoice->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\GradeChoice::setCreatedAt
     * @covers Core\Entity\GradeChoice::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->gradeChoice->setCreatedAt($dt);
        $this->assertEquals($dt, $this->gradeChoice->getCreatedAt());
    }

    /**
     * @covers Core\Entity\GradeChoice::setUpdatedAt
     * @covers Core\Entity\GradeChoice::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->gradeChoice->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->gradeChoice->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\GradeChoice::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $gradeChoice = new GradeChoice($this->mockEntityManager);

        $gradeChoice->refreshTimeStamps();
        $createdAt = $gradeChoice->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($gradeChoice->getUpdatedAt());

        $gradeChoice->refreshTimeStamps();
        $updatedAt = $gradeChoice->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $gradeChoice->getCreatedAt());
    }

}




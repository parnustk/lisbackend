<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\StudentGroup;
use DateTime;

/**
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class StudentGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\StudentGroup 
     */
    protected $studentGroup;

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

        $studentGroup = new StudentGroup($this->mockEntityManager);
        $this->studentGroup = $studentGroup;
    }

    /**
     * @covers Core\Entity\StudentGroup::setId
     * @covers Core\Entity\StudentGroup::getId
     */
    public function testSetGetId()
    {
        $this->studentGroup->setId(1);
        $this->assertEquals(1, $this->studentGroup->getId());
    }

    /**
     * @covers Core\Entity\StudentGroup::setName
     * @covers Core\Entity\StudentGroup::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->studentGroup->setName($name);
        $this->assertEquals($name, $this->studentGroup->getName());
    }

    /**
     * @covers Core\Entity\StudentGroup::setVocation
     * @covers Core\Entity\StudentGroup::getVocation
     */
    public function testSetGetVocation()
    {
        $mockVocation = $this
                ->getMockBuilder('Core\Entity\Vocation')
                ->getMock();

        $this->studentGroup->setVocation($mockVocation);
        $this->assertEquals($mockVocation, $this->studentGroup->getVocation());
    }

    /**
     * @covers Core\Entity\StudentGroup::setSubjectRound
     * @covers Core\Entity\StudentGroup::getSubjectRound
     */
    public function testSetGetSubjectRound()
    {
        $mockSubjectRound = $this
                ->getMockBuilder('Core\Entity\SubjectRound')
                ->getMock();

        $this->studentGroup->setSubjectRound($mockSubjectRound);
        $this->assertEquals($mockSubjectRound, $this->studentGroup->getSubjectRound());
    }

    /**
     * @covers Core\Entity\StudentGroup::setStudentInGroups
     * @covers Core\Entity\StudentGroup::getStudentInGroups
     */
    public function testSetGetStudentInGroups()
    {
        $mockStudentInGroups = $this
                ->getMockBuilder('Core\Entity\StudentInGroups')
                ->getMock();

        $this->studentGroup->setStudentInGroups($mockStudentInGroups);
        $this->assertEquals($mockStudentInGroups, $this->studentGroup->getStudentInGroups());
    }

    /**
     * @covers Core\Entity\StudentGroup::setTrashed
     * @covers Core\Entity\StudentGroup::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->studentGroup->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->studentGroup->getTrashed());

        $trashedString = "A";
        $this->studentGroup->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->studentGroup->getTrashed());
    }

    /**
     * @covers Core\Entity\StudentGroup::setCreatedBy
     * @covers Core\Entity\StudentGroup::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->studentGroup->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->studentGroup->getCreatedBy());
    }

    /**
     * @covers Core\Entity\StudentGroup::setUpdatedBy
     * @covers Core\Entity\StudentGroup::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->studentGroup->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->studentGroup->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\StudentGroup::setCreatedAt
     * @covers Core\Entity\StudentGroup::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->studentGroup->setCreatedAt($dt);
        $this->assertEquals($dt, $this->studentGroup->getCreatedAt());
    }

    /**
     * @covers Core\Entity\StudentGroup::setUpdatedAt
     * @covers Core\Entity\StudentGroup::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->studentGroup->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->studentGroup->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\StudentGroup::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $studentGroup = new StudentGroup($this->mockEntityManager);

        $studentGroup->refreshTimeStamps();
        $createdAt = $studentGroup->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($studentGroup->getUpdatedAt());

        $studentGroup->refreshTimeStamps();
        $updatedAt = $studentGroup->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $studentGroup->getCreatedAt());
    }

}


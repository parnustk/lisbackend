<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\GradingType;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class GradingTypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\GradingType
     */
    protected $gradingType;

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

        $gradingType = new GradingType($this->mockEntityManager);
        $this->gradingType = $gradingType;
    }

    /**
     * @covers Core\Entity\GradingType::setId
     * @covers Core\Entity\GradingType::getId
     */
    public function testSetGetId()
    {
        $this->gradingType->setId(1);
        $this->assertEquals(1, $this->gradingType->getId());
    }

    /**
     * @covers Core\Entity\GradingType::setGradingType
     * @covers Core\Entity\GradingType::getGradingType
     */
    public function testSetGetGradingType()
    {
        $gradingType = 'Name';
        $this->gradingType->setGradingType($gradingType);
        $this->assertEquals($gradingType, $this->gradingType->getGradingType());
    }

    /**
     * @covers Core\Entity\GradingType::setModule
     * @covers Core\Entity\GradingType::getModule
     */
    public function testSetGetModule()
    {
        $mockModule = $this
                ->getMockBuilder('Core\Entity\Module')
                ->getMock();

        $this->gradingType->setModule($mockModule);
        $this->assertEquals($mockModule, $this->gradingType->getModule());
    }

    /**
     * @covers Core\Entity\GradingType::setSubject
     * @covers Core\Entity\GradingType::getSubject
     */
    public function testSetGetSubject()
    {
        $mockSubject = $this
                ->getMockBuilder('Core\Entity\Subject')
                ->getMock();

        $this->gradingType->setSubject($mockSubject);
        $this->assertEquals($mockSubject, $this->gradingType->getSubject());
    }

    /**
     * @covers Core\Entity\GradingType::setTrashed
     * @covers Core\Entity\GradingType::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->gradingType->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->gradingType->getTrashed());

        $trashedString = "A";
        $this->gradingType->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->gradingType->getTrashed());
    }

    /**
     * @covers Core\Entity\GradingType::setCreatedBy
     * @covers Core\Entity\GradingType::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->gradingType->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->gradingType->getCreatedBy());
    }

    /**
     * @covers Core\Entity\GradingType::setUpdatedBy
     * @covers Core\Entity\GradingType::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->gradingType->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->gradingType->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\GradingType::setCreatedAt
     * @covers Core\Entity\GradingType::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->gradingType->setCreatedAt($dt);
        $this->assertEquals($dt, $this->gradingType->getCreatedAt());
    }

    /**
     * @covers Core\Entity\GradingType::setUpdatedAt
     * @covers Core\Entity\GradingType::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->gradingType->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->gradingType->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\GradingType::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $gradingType = new GradingType($this->mockEntityManager);

        $gradingType->refreshTimeStamps();
        $createdAt = $gradingType->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($gradingType->getUpdatedAt());

        $gradingType->refreshTimeStamps();
        $updatedAt = $gradingType->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $gradingType->getCreatedAt());
    }

}

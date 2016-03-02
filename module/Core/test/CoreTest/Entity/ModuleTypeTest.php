<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\ModuleType;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceReasonTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\ModuleType
     */
    protected $moduleType;

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

        $moduleType = new ModuleType($this->mockEntityManager);
        $this-> moduleType = $moduleType;
    }

    /**
     * @covers Core\Entity\ModuleType::setId
     * @covers Core\Entity\ModuleType::getId
     */
    public function testSetGetId()
    {
        $this->moduleType->setId(1);
        $this->assertEquals(1, $this->moduleType->getId());
    }

    /**
     * @covers Core\Entity\ModuleType::setName
     * @covers Core\Entity\ModuleType::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->moduleType->setName($name);
        $this->assertEquals($name, $this->moduleType->getName());
    }

    /**
     * @covers Core\Entity\ModuleType::setModule
     * @covers Core\Entity\ModuleType::getModule
     */
    public function testSetGetModule()
    {
        $mockModule = $this
                ->getMockBuilder('Core\Entity\Module')
                ->getMock();

        $this->moduleType->setModule($mockModule);
        $this->assertEquals($mockModule, $this->moduleType->getModule());
    }

    /**
     * @covers Core\Entity\ModuleType::setTrashed
     * @covers Core\Entity\ModuleType::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->moduleType->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->moduleType->getTrashed());

        $trashedString = "A";
        $this->moduleType->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->moduleType->getTrashed());
    }

    /**
     * @covers Core\Entity\ModuleType::setCreatedBy
     * @covers Core\Entity\ModuleType::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->moduleType->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->moduleType->getCreatedBy());
    }

    /**
     * @covers Core\Entity\ModuleType::setUpdatedBy
     * @covers Core\Entity\ModuleType::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->moduleType->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->moduleType->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\ModuleType::setCreatedAt
     * @covers Core\Entity\ModuleType::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->moduleType->setCreatedAt($dt);
        $this->assertEquals($dt, $this->moduleType->getCreatedAt());
    }

    /**
     * @covers Core\Entity\ModuleType::setUpdatedAt
     * @covers Core\Entity\ModuleType::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->moduleType->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->moduleType->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\ModuleType::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $moduleType = new ModuleType($this->mockEntityManager);

        $moduleType->refreshTimeStamps();
        $createdAt = $moduleType->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($moduleType->getUpdatedAt());

        $moduleType->refreshTimeStamps();
        $updatedAt = $moduleType->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $moduleType->getCreatedAt());
    }

}

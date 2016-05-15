<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Module;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Module 
     */
    protected $module;

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

        $module = new Module($this->mockEntityManager);
        $this->module = $module;
    }

    /**
     * @covers Core\Entity\Module::setId
     * @covers Core\Entity\Module::getId
     */
    public function testSetGetId()
    {
        $this->module->setId(1);
        $this->assertEquals(1, $this->module->getId());
    }

    /**
     * @covers Core\Entity\Module::setName
     * @covers Core\Entity\Module::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->module->setName($name);
        $this->assertEquals($name, $this->module->getName());
    }

    /**
     * @covers Core\Entity\Module::setDuration
     * @covers Core\Entity\Module::getDuration
     */
    public function testSetGetDuration()
    {
        $duration = '85';
        $this->module->setDuration($duration);
        $this->assertEquals($duration, $this->module->getDuration());
    }

    /**
     * @covers Core\Entity\Module::setModuleCode
     * @covers Core\Entity\Module::getModuleCode
     */
    public function testSetGetCode()
    {
        $code = '123456abscef';
        $this->module->setModuleCode($code);
        $this->assertEquals($code, $this->module->getModuleCode());
    }

    /**
     * @covers Core\Entity\Module::setSubject
     * @covers Core\Entity\Module::getSubject
     */
    public function testSetGetSubject()
    {
        $mockSubject = $this
                ->getMockBuilder('Core\Entity\Subject')
                ->getMock();

        $this->module->setSubject($mockSubject);
        $this->assertEquals($mockSubject, $this->module->getSubject());
    }

    /**
     * @covers Core\Entity\Module::setStudentGrade
     * @covers Core\Entity\Module::getStudentGrade
     */
    public function testSetGetStudentGrade()
    {
        $mockStudentGrade = $this
                ->getMockBuilder('Core\Entity\StudentGrade')
                ->getMock();

        $this->module->setStudentGrade($mockStudentGrade);
        $this->assertEquals($mockStudentGrade, $this->module->getStudentGrade());
    }

    /**
     * @covers Core\Entity\Module::setVocation
     * @covers Core\Entity\Module::getVocation
     */
    public function testSetGetVocation()
    {
        $mockVocation = $this
                ->getMockBuilder('Core\Entity\Vocation')
                ->getMock();

        $this->module->setVocation($mockVocation);
        $this->assertEquals($mockVocation, $this->module->getVocation());
    }

    /**
     * @covers Core\Entity\Module::setModuleType
     * @covers Core\Entity\Module::getModuleType
     */
    public function testSetGetModuleType()
    {
        $mockModuleType = $this
                ->getMockBuilder('Core\Entity\ModuleType')
                ->getMock();

        $this->module->setModuleType($mockModuleType);
        $this->assertEquals($mockModuleType, $this->module->getModuleType());
    }

    /**
     * @covers Core\Entity\Module::setGradingType
     * @covers Core\Entity\Module::getGradingType
     */
    public function testSetGetGradingType()
    {
        $mockGradingType = $this
                ->getMockBuilder('Core\Entity\GradingType')
                ->getMock();

        $this->module->setGradingType($mockGradingType);
        $this->assertEquals($mockGradingType, $this->module->getGradingType());
    }

    /**
     * @covers Core\Entity\Module::setTrashed
     * @covers Core\Entity\Module::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->module->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->module->getTrashed());

        $trashedString = "A";
        $this->module->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->module->getTrashed());
    }

    /**
     * @covers Core\Entity\Module::setCreatedBy
     * @covers Core\Entity\Module::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->module->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->module->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Module::setUpdatedBy
     * @covers Core\Entity\Module::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->module->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->module->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Module::setCreatedAt
     * @covers Core\Entity\Module::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->module->setCreatedAt($dt);
        $this->assertEquals($dt, $this->module->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Module::setUpdatedAt
     * @covers Core\Entity\Module::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->module->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->module->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\Module::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $module = new Module($this->mockEntityManager);

        $module->refreshTimeStamps();
        $createdAt = $module->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($module->getUpdatedAt());

        $module->refreshTimeStamps();
        $updatedAt = $module->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $module->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Module::addGradingType
     * @covers Core\Entity\Module::removeGradingType
     */
    public function testAddRemoveGradingType()
    {
        $ml = new Module;
        $this->assertEquals(0, $ml->getGradingType()->count());

        $mockGradingType = $this
                ->getMockBuilder('Core\Entity\GradingType')
                ->getMock();

        $gradingtypes = new \Doctrine\Common\Collections\ArrayCollection();

        $gradingtypes->add($mockGradingType);

        $ml->addGradingType($gradingtypes);

        $this->assertEquals(1, $ml->getGradingType()->count());
        $this->assertEquals($mockGradingType, $ml->getGradingType()->first());

        $ml->removeGradingType($gradingtypes);
        $this->assertEquals(0, $ml->getGradingType()->count());
    }

}

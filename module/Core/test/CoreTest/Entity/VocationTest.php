<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Vocation;
use DateTime;

/**
 * Description of VocationTest
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class VocationTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Vocation 
     */
    protected $vocation;

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

        $vocation = new Vocation($this->mockEntityManager);
        $this->vocation = $vocation;
    }

    /**
     * @covers Core\Entity\Vocation::setId
     * @covers Core\Entity\Vocation::getId
     */
    public function testSetGetId()
    {
        $this->vocation->setId(1);
        $this->assertEquals(1, $this->vocation->getId());
    }

    /**
     * @covers Core\Entity\Vocation::setName
     * @covers Core\Entity\Vocation::getName
     */
    public function testSetGetName()
    {
        $name = "Name";
        $this->vocation->setName($name);
        $this->assertEquals($this->vocation->getName(), $name);
    }

    /**
     * @covers Core\Entity\Vocation::setVocationCode
     * @covers Core\Entity\Vocation::getVocationCode
     */
    public function testSetGetVocationCode()
    {
        $code = "N001";
        $this->vocation->setVocationCode($code);
        $this->assertEquals($this->vocation->getVocationCode(), $code);
    }

    /**
     * @covers Core\Entity\Vocation::setDurationEKAP
     * @covers Core\Entity\Vocation::getDurationEKAP
     */
    public function testSetGetDurationEKAP()
    {
        $ekap = 120;
        $this->vocation->setDurationEKAP($ekap);
        $this->assertEquals($this->vocation->getDurationEKAP(), $ekap);
    }

    /**
     * @covers Core\Entity\Vocation::setStudentGroup
     * @covers Core\Entity\Vocation::getStudentGroup
     */
    public function testSetGetStudentGroup()
    {
        $sg = $this->getMockBuilder('Core\Entity\StudentGroup')
                ->getMock();
        $this->vocation->setStudentGroup($sg);
        $this->assertEquals($this->vocation->getStudentGroup(), $sg);
    }

    /**
     * @covers Core\Entity\Vocation::setModule
     * @covers Core\Entity\Vocation::getModule
     */
    public function testSetGetModule()
    {
        $m = $this->getMockBuilder('Core\Entity\Module')
                ->getMock();
        $this->vocation->setModule($m);
        $this->assertEquals($this->vocation->getModule(), $m);
    }

    /**
     * @covers Core\Entity\Vocation::setTrashed
     * @covers Core\Entity\Vocation::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->vocation->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->vocation->getTrashed());

        $trashedString = "A";
        $this->vocation->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->vocation->getTrashed());
    }

    /**
     * @covers Core\Entity\Vocation::setCreatedAt
     * @covers Core\Entity\Vocation::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->vocation->setCreatedAt($dt);
        $this->assertEquals($dt, $this->vocation->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Vocation::setUpdatedAt
     * @covers Core\Entity\Vocation::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->vocation->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->vocation->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\Vocation::setCreatedBy
     * @covers Core\Entity\Vocation:getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->vocation->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->vocation->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Vocation::setUpdatedBy
     * @covers Core\Entity\Vocation::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->vocation->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->vocation->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Vocation::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $vocation = new Vocation($this->mockEntityManager);

        $vocation->refreshTimeStamps();
        $createdAt = $vocation->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($vocation->getUpdatedAt());

        $vocation->refreshTimeStamps();
        $updatedAt = $vocation->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $vocation->getCreatedAt());
    }

}

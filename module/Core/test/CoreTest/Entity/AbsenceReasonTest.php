<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\AbsenceReason;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceReasonTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\AbsenceReason
     */
    protected $absenceReason;

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

        $absenceReason = new AbsenceReason($this->mockEntityManager);
        $this->absenceReason = $absenceReason;
    }

    /**
     * @covers Core\Entity\Absence::setId
     * @covers Core\Entity\Absence::getId
     */
    public function testSetGetId()
    {
        $this->absenceReason->setId(1);
        $this->assertEquals(1, $this->absenceReason->getId());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setName
     * @covers Core\Entity\AbsenceReason::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->absenceReason->setName($name);
        $this->assertEquals($name, $this->absenceReason->getName());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setAbsence
     * @covers Core\Entity\AbsenceReason::getAbsence
     */
    public function testSetGetAbsence()
    {
        $mockAbsence = $this
                ->getMockBuilder('Core\Entity\Absence')
                ->getMock();

        $this->absenceReason->setAbsence($mockAbsence);
        $this->assertEquals($mockAbsence, $this->absenceReason->getAbsence());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setTrashed
     * @covers Core\Entity\AbsenceReason::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->absenceReason->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->absenceReason->getTrashed());

        $trashedString = "A";
        $this->absenceReason->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->absenceReason->getTrashed());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setCreatedBy
     * @covers Core\Entity\AbsenceReason::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->absenceReason->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->absenceReason->getCreatedBy());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setUpdatedBy
     * @covers Core\Entity\AbsenceReason::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->absenceReason->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->absenceReason->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setCreatedAt
     * @covers Core\Entity\AbsenceReason::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->absenceReason->setCreatedAt($dt);
        $this->assertEquals($dt, $this->absenceReason->getCreatedAt());
    }

    /**
     * @covers Core\Entity\AbsenceReason::setUpdatedAt
     * @covers Core\Entity\AbsenceReason::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->absenceReason->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->absenceReason->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\AbsenceReason::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $absenceReason = new AbsenceReason($this->mockEntityManager);

        $absenceReason->refreshTimeStamps();
        $createdAt = $absenceReason->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($absenceReason->getUpdatedAt());

        $absenceReason->refreshTimeStamps();
        $updatedAt = $absenceReason->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $absenceReason->getCreatedAt());
    }

}

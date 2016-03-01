<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Controller;

use Core\Entity\Absence;
use DateTime;

/**
 * Description of AbsenceTest
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AbsenceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Absence 
     */
    protected $absence;

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

        $absence = new Absence($this->mockEntityManager);
        $this->absence = $absence;
    }

    /**
     * @covers Core\Entity\Absence::setId
     * @covers Core\Entity\Absence::getId
     */
    public function testSetGetId()
    {
        $this->absence->setId(1);
        $this->assertEquals(1, $this->absence->getId());
    }

    /**
     * @covers Core\Entity\Absence::setDescription
     * @covers Core\Entity\Absence::getDescription
     */
    public function testSetGetDescription()
    {
        $description = 'Description';
        $this->absence->setDescription($description);
        $this->assertEquals($description, $this->absence->getDescription());
    }

    /**
     * @covers Core\Entity\Absence::setAbsenceReason
     * @covers Core\Entity\Absence::getAbsenceReason
     */
    public function testSetGetAbsenceReason()
    {
        $mockAbsenceReason = $this
                ->getMockBuilder('Core\Entity\AbsenceReason')
                ->getMock();

        $this->absence->setAbsenceReason($mockAbsenceReason);
        $this->assertEquals($mockAbsenceReason, $this->absence->getAbsenceReason());
    }

    /**
     * @covers Core\Entity\Absence::setStudent
     * @covers Core\Entity\Absence::getStudent
     */
    public function testSetGetStudent()
    {
        $mockStudent = $this
                ->getMockBuilder('Core\Entity\Student')
                ->getMock();

        $this->absence->setStudent($mockStudent);
        $this->assertEquals($mockStudent, $this->absence->getStudent());
    }

    /**
     * @covers Core\Entity\Absence::setContactLesson
     * @covers Core\Entity\Absence::getContactLesson
     */
    public function testSetGetContactLesson()
    {
        $mockContactLesson = $this
                ->getMockBuilder('Core\Entity\ContactLesson')
                ->getMock();

        $this->absence->setContactLesson($mockContactLesson);
        $this->assertEquals($mockContactLesson, $this->absence->getContactLesson());
    }

    /**
     * @covers Core\Entity\Absence::setTrashed
     * @covers Core\Entity\Absence::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->absence->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->absence->getTrashed());

        $trashedString = "A";
        $this->absence->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->absence->getTrashed());
    }

    /**
     * @covers Core\Entity\Absence::setCreatedBy
     * @covers Core\Entity\Absence::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->absence->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->absence->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Absence::setUpdatedBy
     * @covers Core\Entity\Absence::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->absence->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->absence->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Absence::setCreatedAt
     * @covers Core\Entity\Absence::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->absence->setCreatedAt($dt);
        $this->assertEquals($dt, $this->absence->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Absence::setUpdatedAt
     * @covers Core\Entity\Absence::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->absence->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->absence->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\Absence::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $absence = new Absence($this->mockEntityManager);

        $absence->refreshTimeStamps();
        $createdAt = $absence->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($absence->getUpdatedAt());

        $absence->refreshTimeStamps();
        $updatedAt = $absence->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $absence->getCreatedAt());
    }

}

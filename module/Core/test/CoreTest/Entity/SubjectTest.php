<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Subject;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Subject
     */
    protected $subject;

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

        $subject = new Subject($this->mockEntityManager);
        $this->subject = $subject;
    }

    /**
     * @covers Core\Entity\Subject::setId
     * @covers Core\Entity\Subject::getId
     */
    public function testSetGetId()
    {
        $this->subject->setId(1);
        $this->assertEquals(1, $this->subject->getId());
    }
    
    /**
     * @covers Core\Entity\Subject::setSubjectCode
     * @covers Core\Entity\Subject::getSubjectCode
     */
    public function testSetGetSubjectCode()
    {
        $code = '123456abscef';
        $this->subject->setSubjectCode($code);
        $this->assertEquals($code, $this->subject->getSubjectCode());
    }
    
    /**
     * @covers Core\Entity\Subject::setName
     * @covers Core\Entity\Subject::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->subject->setName($name);
        $this->assertEquals($name, $this->subject->getName());
    }
    
    /**
     * @covers Core\Entity\Subject::setDurationAllAK
     * @covers Core\Entity\Subject::getDurationAllAK
     */
    public function testSetGetDurationAllAK()
    {
        $duration = '85';
        $this->subject->setDurationAllAK($duration);
        $this->assertEquals($duration, $this->subject->getDurationAllAK());
    }
    
    /**
     * @covers Core\Entity\Subject::setDurationContactAK
     * @covers Core\Entity\Subject::getDurationContactAK
     */
    public function testSetGetDurationContactAK()
    {
        $duration = '85';
        $this->subject->setDurationContactAK($duration);
        $this->assertEquals($duration, $this->subject->getDurationContactAK());
    }

    /**
     * @covers Core\Entity\Subject::setDurationIndependentAK
     * @covers Core\Entity\Subject::getDurationIndependentAK
     */
    public function testSetGetDurationIndependentAK()
    {
        $duration = '85';
        $this->subject->setDurationIndependentAK($duration);
        $this->assertEquals($duration, $this->subject->getDurationIndependentAK());
    }

    /**
     * @covers Core\Entity\Subject::setSubjectRound
     * @covers Core\Entity\Subject::getSubjectRound
     */
    public function testSetGetSubjectRound()
    {
        $mockSubjectRound = $this
                ->getMockBuilder('Core\Entity\SubjectRound')
                ->getMock();

        $this->subject->setSubjectRound($mockSubjectRound);
        $this->assertEquals($mockSubjectRound, $this->subject->getSubjectRound());
    }
    
    /**
     * @covers Core\Entity\Subject::setModule
     * @covers Core\Entity\Subject::getModule
     */
    public function testSetGetModule()
    {
        $mockModule = $this
                ->getMockBuilder('Core\Entity\Module')
                ->getMock();

        $this->subject->setModule($mockModule);
        $this->assertEquals($mockModule, $this->subject->getModule());
    }
    
    /**
     * @covers Core\Entity\Subject::setGradingType
     * @covers Core\Entity\Subject::getGradingType
     */
    public function testSetGetGradingType()
    {
        $mockGradingType = $this
                ->getMockBuilder('Core\Entity\GradingType')
                ->getMock();

        $this->subject->setGradingType($mockGradingType);
        $this->assertEquals($mockGradingType, $this->subject->getGradingType());
    }

    /**
     * @covers Core\Entity\Subject::setTrashed
     * @covers Core\Entity\Subject::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->subject->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->subject->getTrashed());

        $trashedString = "A";
        $this->subject->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->subject->getTrashed());
    }

    /**
     * @covers Core\Entity\Subject::setCreatedBy
     * @covers Core\Entity\Subject::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->subject->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->subject->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Subject::setUpdatedBy
     * @covers Core\Entity\Subject::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->subject->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->subject->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Subject::setCreatedAt
     * @covers Core\Entity\Subject::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->subject->setCreatedAt($dt);
        $this->assertEquals($dt, $this->subject->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Subject::setUpdatedAt
     * @covers Core\Entity\Subject::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->subject->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->subject->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\SubjectRound::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $subject = new Subject($this->mockEntityManager);

        $subject->refreshTimeStamps();
        $createdAt = $subject->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($subject->getUpdatedAt());

        $subject->refreshTimeStamps();
        $updatedAt = $subject->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $subject->getCreatedAt());
    }

    /**
     * @covers Core\Entity\SubjectRound::addTeacher
     * @covers Core\Entity\SubjectRound::removeTeacher
     */
    public function testAddRemoveGradingType()
    {
        $s = new Subject;
        $this->assertEquals(0, $s->getGradingType()->count());

        $mockGradingType = $this
                ->getMockBuilder('Core\Entity\GradingType')
                ->getMock();

        $gradingTypes = new \Doctrine\Common\Collections\ArrayCollection();

        $gradingTypes->add($mockGradingType);

        $s->addGradingType($gradingTypes);

        $this->assertEquals(1, $s->getGradingType()->count());
        $this->assertEquals($mockGradingType, $s->getGradingType()->first());

        $s->removeGradingType($gradingTypes);
        $this->assertEquals(0, $s->getGradingType()->count());
    }

}

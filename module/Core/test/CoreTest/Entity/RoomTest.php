<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Rooms;
use DateTime;

/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
class RoomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Core\Entity\Rooms
     */
    protected $room;
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $mockEntityManager;
    
    public function setUp()
    {
        $this->mockEntityManager = $this
                ->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();
        
        $room = new Rooms($this->mockEntityManager);
        $this->room = $room;
    }


    /**
    * @covers Core\Entity\Rooms::setId
    * @covers Core\Entity\Rooms::getId
    */
    public function testSetGetId()
    {
    $this->room->setId(1);
    $this->assertEquals(1, $this->room->getId());
    }

    /**
     * @covers Core\Entity\Rooms::setName
     * @covers Core\Entity\Rooms::getName
     */
    public function testSetGetName()
    {
        $name = 'Name';
        $this->room->setName($name);
        $this->assertEquals($name, $this->room->getName());
    }
    
    /**
     * @covers Core\Entity\Rooms::setContactLesson
     * @covers Core\Entity\Rooms::getContactLesson
     */
    public function testSetGetContactLesson()
    {
        $ct = 'ContactLesson';
        $this->room->setContactLesson($ct);
        $this->assertEquals($ct, $this->room->getContactLesson());
    }
    
    /**
     * @covers Core\Entity\Rooms::setTrashed
     * @covers Core\Entity\Rooms::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->room->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->room->getTrashed());
        
        $trashedString = "A";
        $this->room->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->room->getTrashed());
    }
    
    /**
     * @covers Core\Entity\Rooms::setCreatedBy
     * @covers Core\Entity\Rooms::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();
        $this->room->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->room->getCreatedBy());
        
    }
    
    /**
     * @covers Core\Entity\Rooms::setUpdatedBy
     * @covers Core\Entity\Rooms::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();
        $this->room->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->room->getUpdatedBy());
        
    }
    
    /**
     * @covers Core\Entity\Rooms::setCreatedAt
     * @covers Core\Entity\Rooms::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->room->setCreatedAt($dt); 
        $this->assertEquals($dt, $this->room->getCreatedAt());
    }
    
    /**
     * @covers Core\Entity\Rooms::setUpdatedAt
     * @covers Core\Entity\Rooms::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->room->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->room->getUpdatedAt());
    }
    
    /**
     * @covers Core\Entity\Rooms::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $room = new Rooms($this->mockEntityManager);
        
        $room->refreshTimeStamps();
        $createdAt = $room->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($room->getUpdatedAt());
        
        $room->refreshTimeStamps();
        $updatedAt = $room->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $room->getCreatedAt());
    }
}

<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\Administrator;
use DateTime;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AdministratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\Administrator
     */
    protected $administrator;

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

        $administrator = new Administrator($this->mockEntityManager);
        $this->administrator = $administrator;
    }

    /**
     * @covers Core\Entity\Administrator::setId
     * @covers Core\Entity\Administrator::getId
     */
    public function testSetGetId()
    {
        $this->administrator->setId(1);
        $this->assertEquals(1, $this->administrator->getId());
    }

    /**
     * @covers Core\Entity\Administrator::setFirstName
     * @covers Core\Entity\Administrator::getFirstName
     */
    public function testSetGetFirstName()
    {
        $name = 'Name';
        $this->administrator->setFirstName($name);
        $this->assertEquals($name, $this->administrator->getFirstName());
    }

    /**
     * @covers Core\Entity\Administrator::setLastName
     * @covers Core\Entity\Administrator::getLastName
     */
    public function testSetGetLastName()
    {
        $name = 'Name';
        $this->administrator->setLastName($name);
        $this->assertEquals($name, $this->administrator->getLastName());
    }

    /**
     * @covers Core\Entity\Administrator::setEmail
     * @covers Core\Entity\Administrator::getEmail
     */
    public function testSetGetEmail()
    {
        $email = 'Description@me.ee';
        $this->administrator->setEmail($email);
        $this->assertEquals($email, $this->administrator->getEmail());
    }

    /**
     * @covers Core\Entity\Administrator::setPersonalCode
     * @covers Core\Entity\Administrator::getPersonalCode
     */
    public function testSetGetPersonalCode()
    {
        $personalCode = '85e67';
        $this->administrator->setPersonalCode($personalCode);
        $this->assertEquals($personalCode, $this->administrator->getPersonalCode());
    }

    /**
     * @covers Core\Entity\Administrator::setLisUser
     * @covers Core\Entity\Administrator::getLisUser
     */
    public function testSetGetLisUser()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->administrator->setLisUser($mockLisUser);
        $this->assertEquals($mockLisUser, $this->administrator->getLisUser());
    }

    /**
     * @covers Core\Entity\Administrator::setSuperAdministrator
     * @covers Core\Entity\Administrator::getSuperAdministrator
     */
    public function testSetGetSuperAdministrator()
    {
        $superAdministrator = '1';
        $this->administrator->setSuperAdministrator($superAdministrator);
        $this->assertEquals($superAdministrator, $this->administrator->getSuperAdministrator());
    }

    /**
     * @covers Core\Entity\Administrator::setTrashed
     * @covers Core\Entity\Administrator::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->administrator->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->administrator->getTrashed());

        $trashedString = "A";
        $this->administrator->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->administrator->getTrashed());
    }

    /**
     * @covers Core\Entity\Administrator::setCreatedBy
     * @covers Core\Entity\Administrator::getCreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $mockLisUser = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->administrator->setCreatedBy($mockLisUser);
        $this->assertEquals($mockLisUser, $this->administrator->getCreatedBy());
    }

    /**
     * @covers Core\Entity\Administrator::setUpdatedBy
     * @covers Core\Entity\Administrator::getUpdatedBy
     */
    public function testSetGetUpdatedBy()
    {
        $mockUpdatedBy = $this
                ->getMockBuilder('Core\Entity\LisUser')
                ->getMock();

        $this->administrator->setUpdatedBy($mockUpdatedBy);
        $this->assertEquals($mockUpdatedBy, $this->administrator->getUpdatedBy());
    }

    /**
     * @covers Core\Entity\Administrator::setCreatedAt
     * @covers Core\Entity\Administrator::getCreatedAt
     */
    public function testSetGetCreatedAt()
    {
        $dt = new DateTime;
        $this->administrator->setCreatedAt($dt);
        $this->assertEquals($dt, $this->administrator->getCreatedAt());
    }

    /**
     * @covers Core\Entity\Administrator::setUpdatedAt
     * @covers Core\Entity\Administrator::getUpdatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $dt = new DateTime;
        $this->administrator->setUpdatedAt($dt);
        $this->assertEquals($dt, $this->administrator->getUpdatedAt());
    }

    /**
     * @covers Core\Entity\Administrator::refreshTimeStamps
     */
    public function testRefreshTimeStamps()
    {
        $administrator = new Administrator($this->mockEntityManager);

        $administrator->refreshTimeStamps();
        $createdAt = $administrator->getCreatedAt();
        $this->assertNotNull($createdAt);
        $this->assertNull($administrator->getUpdatedAt());

        $administrator->refreshTimeStamps();
        $updatedAt = $administrator->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $this->assertEquals($createdAt, $administrator->getCreatedAt());
    }

}

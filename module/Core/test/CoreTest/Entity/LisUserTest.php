<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity;

use Core\Entity\LisUser;

/**
 * Description of LisUserTest
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LisUserTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Core\Entity\LisUser
     */
    protected $lisuser;

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

        $lisuser = new LisUser($this->mockEntityManager);
        $this->lisuser = $lisuser;
    }

    /**
     * @covers Core\Entity\LisUser::setId
     * @covers Core\Entity\LisUser::getId
     */
    public function testSetGetId()
    {
        $this->lisuser->setId(1);
        $this->assertEquals(1, $this->lisuser->getId());
    }

    /**
     * @covers Core\Entity\LisUser::setEmail
     * @covers Core\Entity\LisUser::getEmail
     */
    public function testSetGetEmail()
    {
        $email = "tere@tere.ee";
        $this->lisuser->setEmail($email);
        $this->assertEquals($this->lisuser->getEmail(), $email);
    }

    /**
     * @covers Core\Entity\LisUser::setPassword
     * @covers Core\Entity\LisUser::getPassword
     */
    public function testSetGetPassword()
    {
        $password = "pass12345";
        $this->lisuser->setPassword($password);
        $this->assertEquals($this->lisuser->getPassword(), $password);
    }

    /**
     * @covers Core\Entity\LisUser::setState
     * @covers Core\Entity\LisUser::getState
     */
    public function testSetGetState()
    {
        $state = 1;
        $this->lisuser->setState($state);
        $this->assertEquals($this->lisuser->getState(), $state);
    }

    /**
     * @covers Core\Entity\LisUser::setTeacher
     * @covers Core\Entity\LisUser::getTeacher
     */
    public function testSetGetTeacher()
    {
        $teacher = $this->getMockBuilder('Core\Entity\Teacher')
                ->getMock();
        $this->lisuser->setTeacher($teacher);
        $this->assertEquals($this->lisuser->getTeacher(), $teacher);
    }

    /**
     * @covers Core\Entity\LisUser::setStudent
     * @covers Core\Entity\LisUser::getStudent
     */
    public function testSetGetStudent()
    {
        $student = $this->getMockBuilder('Core\Entity\Student')
                ->getMock();
        $this->lisuser->setStudent($student);
        $this->assertEquals($this->lisuser->getStudent(), $student);
    }

    /**
     * @covers Core\Entity\LisUser::setAdministrator
     * @covers Core\Entity\LisUser::getAdministrator
     */
    public function testSetGetAdministrator()
    {
        $admin = $this->getMockBuilder('Core\Entity\Administrator')
                ->getMock();
        $this->lisuser->setAdministrator($admin);
        $this->assertEquals($this->lisuser->getAdministrator(), $admin);
    }

    /**
     * @covers Core\Entity\LisUser::setTrashed
     * @covers Core\Entity\LisUser::getTrashed
     */
    public function testSetGetTrashed()
    {
        $trashedInt = 1;
        $this->lisuser->setTrashed($trashedInt);
        $this->assertEquals($trashedInt, $this->lisuser->getTrashed());

        $trashedString = "A";
        $this->lisuser->setTrashed($trashedString);
        $this->assertNotEquals($trashedString, $this->lisuser->getTrashed());
    }

}

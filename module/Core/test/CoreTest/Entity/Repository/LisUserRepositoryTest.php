<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Entity\Repository;

use Core\Entity\Repository\LisUserRepository;
use Exception;

/**
 * Description of LisUserRepository
 *
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LisUserRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * setting up an object to testing
     */
    public function setUp()
    {
        $mockEntityManager = $this
                ->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();

        $mockClassMetadata = $this
                ->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
                ->disableOriginalConstructor()
                ->getMock();

        $repository = new LisUserRepository($mockEntityManager, $mockClassMetadata);
        $this->lisUserRepository = $repository;
    }

    /**
     * @covers Core\Entity\Repository\LisUserRepository::Create()
     */
    public function testCreate()
    {
        try {
            $this->lisUserRepository->Create([]);
        } catch (Exception $ex) {
            $this->assertEquals("NO_DATA", $ex->getMessage());
        }
    }

    /**
     * @covers Core\Entity\Repository\LisUserRepository::checkAdministratorUserExists()
     */
    public function testCheckAdministratorUserExists()
    {
        try {
            $this->lisUserRepository->checkAdministratorUserExists("", "");
        } catch (Exception $ex) {
            $this->assertEquals("NO_EMAIL", $ex->getMessage());
            $this->assertEquals("NO_PASSWORD", $ex->getMessage());
        }
    }
/**
     * @covers Core\Entity\Repository\LisUserRepository::passwordToHash()
     */
    public function testPasswordToHash()
    {
        try {
            $this->lisUserRepository->passwordToHash("");
        } catch (Exception $ex) {
            $this->assertEquals("NO_PASSWORD", $ex->getMessage());
        }
    }
}

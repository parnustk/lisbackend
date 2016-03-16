<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Administrator;
use Core\Entity\Repository\AdministratorRepository;
use Exception;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AdministratorRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * 
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
        
        $repository = new AdministratorRepository($mockEntityManager, $mockClassMetadata);
        $this->administratorRepository = $repository;
    }
    
    /**
     * @covers Core\Entity\Repository\AdministratorRepository::Create()
     */
    public function testCreate() {
//        try {
//             $this->administratorRepository->Create([]);
//         } catch (Exception $ex) {
//             $this->assertEquals('"Missing"', $ex->getMessage());
//         }
    }
}
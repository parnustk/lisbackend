<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Repository\RoomsRepository;
use Exception;

/**
 * Testing RoomsRepository using Unit Tests
 * @author Alar Aasa <alar@alaraasa.ee>
 */

class RoomsRepositoryTest extends \PHPUnit_Framework_TestCase
{
    
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
        
        $repository = new RoomsRepository($mockEntityManager, $mockClassMetadata);
        $this->roomsRepository = $repository;
    }
    
    /**
     * @covers Core\Entity\Repository\RoomsRepository::Get()
     */
    public function testGet()
    {
        try{
            $this->roomsRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\RoomsRepository::GetList()
     */
    public function testGetList()
    {
        try {
            $this->roomsRepository->GetList();
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\RoomsRepository::Create()
     */
    public function testCreate()
    {
        try{
            $this->roomsRepository->Create(null,false,null);
        } catch (Exception $ex) {
            $expectedString = 'Argument 1 passed to Core\Utils\EntityValidation::hydrate()';
            $length = strlen($expectedString);
            $string = $ex->getMessage();
            $this->assertEquals($expectedString, substr($string,0,$length));
        }
    }
    
    /**
     * @covers Core\Entity\Repository\RoomsRepository::Delete()
     */
    public function testDelete()
    {
        try{
            $this->roomsRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\RoomsRepository::Update()
     */
    public function testUpdate()
    {
        try{
            $this->roomsRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
}

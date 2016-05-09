<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Vocation;
use Core\Entity\Repository\VocationRepository;
use Exception;

/**
 * Description of VocationRepositoryTest
 *
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class VocationRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var Core\Entity\Repository\VocationRepository
     */
    protected $vocationRepository;
    
    /**
     *
     * @var Doctrine\ORM\RepositoryManager
     */
    protected $mockEntityManager;
    
    /**
     *
     * @var Doctrine\Entity\Vocation
     */
    protected $mockVocation;    
    
    /**
     * 
     */
    public function setUp()
    {   
        $this->mockEntityManager = $this
                ->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();

        $this->mockVocation = $this
                ->getMockBuilder('Core\Entity\Vocation')
                ->disableOriginalConstructor()
                ->getMock();
        
        $mockMetadata = $this
                ->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
                ->disableOriginalConstructor()
                ->getMock();
        
        $vocationRepository = new VocationRepository($this->mockEntityManager,$mockMetadata);
        $this->vocationRepository = $vocationRepository;
    }
    
    /**
     * @covers Core\Entity\Repository\VocationRepository::Get
     */
    public function testGet() {
        try {
            $this->vocationRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\VocationRepository::GetList
     */
    public function testGetList() {
        try {
            $this->vocationRepository->GetList();
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\VocationRepository::Create
     */
    public function testCreate()
    {
        try {
            $this->vocationRepository->Create(null,false,null);
        } catch (Exception $ex) {
            $expectedString = 'Argument 1 passed to Core\Utils\EntityValidation::hydrate()';
            $length = strlen($expectedString);
            $string = $ex->getMessage();
            $this->assertEquals($expectedString, substr($string,0,$length));
        }
    }
    
    /**
     * @covers Core\Entity\Repository\VocationRepository::Delete
     */
    public function testDelete()
    {
        try {
            $this->vocationRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\VocationRepository::Update
     */
    public function testUpdate()
    {
        try {
            $this->vocationRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
}
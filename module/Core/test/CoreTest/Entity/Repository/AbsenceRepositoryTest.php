<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace CoreTest\Repository;

use Core\Entity\Absence;
use Core\Entity\Repository\AbsenceRepository;
use Exception;

/**
 * Description of AbsenceRepositoryTest
 *
 * @author Marten Kähr <marten@kahr.ee>
 */
class AbsenceRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var Core\Entity\Repository\AbsenceRepository
     */
    protected $absenceRepository;
    
    /**
     *
     * @var Doctrine\ORM\RepositoryManager
     */
    protected $mockEntityManager;
    
    /**
     *
     * @var Doctrine\Entity\Absence
     */
    protected $mockAbsence;    
    
    /**
     * 
     */
    public function setUp()
    {   
        $this->mockEntityManager = $this
                ->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();

        $this->mockAbsence = $this
                ->getMockBuilder('Core\Entity\Absence')
                ->disableOriginalConstructor()
                ->getMock();
        
        $mockMetadata = $this
                ->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
                ->disableOriginalConstructor()
                ->getMock();
        
        $absenceRepository = new AbsenceRepository($this->mockEntityManager,$mockMetadata);
        $this->absenceRepository = $absenceRepository;
    }
    
    /**
     * @covers Core\Entity\Repository\AbsenceRepository::Get
     */
    public function testGet() {
        try {
            $this->absenceRepository->Get(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\AbsenceRepository::GetList
     */
    public function testGetList() {
        try {
            $this->absenceRepository->GetList();
        } catch (Exception $ex) {
            $this->assertEquals('NO_ROLE', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\AbsenceRepository::Create
     */
    public function testCreate()
    {
        try {
            $this->absenceRepository->Create(null,false,null);
        } catch (Exception $ex) {
            $expectedString = 'Argument 1 passed to Core\Utils\EntityValidation::hydrate()';
            $length = strlen($expectedString);
            $string = $ex->getMessage();
            $this->assertEquals($expectedString, substr($string,0,$length));
        }
    }
    
    /**
     * @covers Core\Entity\Repository\AbsenceRepository::Delete
     */
    public function testDelete()
    {
        try {
            $this->absenceRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
    
    /**
     * @covers Core\Entity\Repository\AbsenceRepository::Update
     */
    public function testUpdate()
    {
        try {
            $this->absenceRepository->Delete(1);
        } catch (Exception $ex) {
            $this->assertEquals('NOT_FOUND_ENTITY', $ex->getMessage());
        }
    }
}
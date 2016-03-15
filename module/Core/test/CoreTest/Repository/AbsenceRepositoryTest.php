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
     * @covers Core\Entity\Repository::Get
     */
    public function testGet() {
        //Currently throws NOT_FOUND_ENTITY exception.
        //Working As Intended because of mock? Needs different Assert?
        $id = 1;
        $this->assertNotNull($this->absenceRepository->Get($id));
    }
    
    /**
     * @covers Core\Entity\Repository::GetList
     */
    public function testGetList() {
        //Currently throws NO_ROLE exception. Needs definition of mock role?
        $this->assertNotNull($this->absenceRepository->GetList());
    }
}
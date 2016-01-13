<?php

/**
 * LIS development
 * Rest API ControllerTests
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceReasonController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * REST API ControllerTests
 * 
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceReasonControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new AbsenceReasonController();
        parent::setUp();
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     */
    public function testCreate()
    {
        $name = 'AbsenceReason name'.uniqid();
        $this->request->setMethod('post');
        $absencereason = $this->CreateAbsenceReason();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('absencereason', $absencereason->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);
    }
    
    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    /**
     * create one before asking list
     */
    public function testGetList()
    {
        $this->CreateAbsenceReason();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    /**
     * create one before getting
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAbsenceReason()->getId());
        //$myevilhack = $this->CreateAbsenceReason()->getId().'; DROP database lis;'
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    public function testUpdate()
    {
        //create one to  update later on
        $absenceReason = $this->CreateAbsenceReason();
        $id = $absenceReason->getId();
        $nameOld= $absenceReason->getName();
        
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        
        //set new data
        $nameU = uniqid() . 'new name';
        //set new data
        $this->request->setContent(http_build_query([
            "name" => $nameU,
        ]));
  
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);
        //print_r($result->data['name']);
        
        $this->assertNotEquals($nameOld, $result->data['name']);
        
    }
    
    public function testDelete()
    {
        
        $entity = $this->CreateAbsenceReason();
        $idOld = $entity->getId();      

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\AbsenceReason')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }
    
    public function testCreatedAtAndUpdatedAt()
    {
        $name = 'AbsenceReasonName' . uniqid();
        $this->request->setMethod('post');
        $absencereason = $this->CreateAbsenceReason();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('absencereason', $absencereason->getId());

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);

        $repository = $this->em->getRepository('Core\Entity\AbsenceReason');
        $newAbsenceReason = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newAbsenceReason->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newAbsenceReason->getUpdatedBy()->getId());
    }

}

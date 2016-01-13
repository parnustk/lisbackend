<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\RoomController;

/**
  * @author Alar Aasa
  */

class RoomControllerTest extends UnitHelpers
{
     /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new RoomController();
        parent::setUp();
    }

    /*
     * Tests create without any data
     */
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
     * Test create with data
     */
    public function testCreate()
    {
        $name = 'Classroom name' . uniqid();
        
        $this->request->setMethod('post');
        
        $room = $this->CreateRoom();
        $this->request->getPost()->set('name', $name);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, false);         
    }
    
  
    
    /**
     * testing GET
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateRoom()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    /**
     * TEST rows get read
     */
    public function testGetList()
    {       
        $this->CreateRoom();
        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }
    
    /**
     * TEST row gets updated by id
     */
    public function testUpdate()
    {
        $entity = $this->CreateRoom();
        $id = $entity->getId();

        $nameOld = $entity->getName();

        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'name' => uniqid() . 'room',
        ]));
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $r = $this->em
                ->getRepository('Core\Entity\Rooms')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $nameOld, $r->getName()
                );
        $this->PrintOut($result, false);

    }
    
    public function testDelete()
    {
        $entity = $this->CreateRoom();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Rooms')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }
    
    public function testCreateWithCreatedByAndUpdatedBy(){
        $this->request->setMethod('post');

        $roomName = uniqid() . 'roomname';
        $this->request->getPost()->set('name', $roomName);
        
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
        
        $repository = $this->em->getRepository('Core\Entity\Rooms');
        $newRoom = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newRoom->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newRoom->getUpdatedBy()->getId());
    }
    
    public function testCreatedWithCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');
        
        $roomName = uniqid() . 'roomname';
        $this->request->getPost()->set('name', $roomName);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
        
        $repository = $this->em->getRepository('Core\Entity\Rooms');
        $newRoom = $repository->find($result->data['id']);
        $this->assertNotNull($newRoom->getCreatedAt());
        $this->assertNotNull($newRoom->getUpdatedAt());
        
    }
}

<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\RoomController;

class RoomControllerTest extends UnitHelpers
{
    /**
     * @author alar aasa
     */
    protected function setUp()
    {
        $this->controller = new RoomController();
        parent::setUp();
    }

    /**
     * Imitate POST request
     */
    public function testCreate()
    {
        $name = 'Classroom name' . uniqid();
        
        $this->request->setMethod('post');
        $this->request->getPost()->set('name', $name);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);         
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
        $this->PrintOut($result, FALSE);

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
    
    public function testCreatedBy()
    {
        $name = 'Classroom name' . uniqid();
        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set('lisUser', $lisUser->getId());
        
        $this->request->setMethod('post');
        $this->request->getPost()->set('name', $name);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);         
    } 
    
    public function testCreatedWithCreatedAtAndUpdatedAt()
    {
        $this->assertNotNull($newRoom->getCreatedAt());
        $this->assertNotNull($newRoom->getUpdatedAt());
        
        
        
    }
}

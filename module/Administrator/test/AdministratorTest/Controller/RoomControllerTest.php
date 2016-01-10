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
        $name = 'Classroom name';
        $this->request->setMethod('post');
        $this->request->getPost()->set('name', $name);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);         
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
        $this->PrintOut($result, FALSE);
    }
    
    /**
     * testing PUT
     */
    public function testUpdate()
    {
        $room = $this->CreateRoom();
        
        $nameOld = $room->getName();
        
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $room->getId());
        
        $name = uniqid() . "name";
        $this->request->setContent(http_build_query([
            "name" => $name,
        ]));
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->assertNotEquals($nameOld, $result->data["name"]);
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
}

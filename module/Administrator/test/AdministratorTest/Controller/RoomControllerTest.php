<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\RoomController;

class RoomControllerTest extends UnitHelpers
{

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
//       
        $this->request->getPost()->set('name', $name);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
//        
        $this->PrintOut($result, true);
//                
    }

}

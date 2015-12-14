<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\GroupController;

class GroupControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new GroupController();
        parent::setUp();
    }

    /**
     * Imitate POST request
     */
    public function testCreate()
    {
        $this->request->setMethod('post');
        
        $this->request->getPost()->set('name', 'TESTname');
        $this->request->getPost()->set('Pärnu', 'Linn');
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, true);
                
    }

}

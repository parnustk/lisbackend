<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectRoundController;

class SubjectRoundControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectRoundController();
        parent::setUp();
    }

    /**
     * Imitate POST request
     */
    public function testCreate()
    {
        $this->request->setMethod('post');
     
        $this->request->getPost()->set('name', 'TEST');

        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        
//        $this->PrintOut($result, true);
                
    }

}

<?php

/**
 * Description of AbsenceReasonControllerTest
 *
 * @author eleri
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceReasonController;

class AbsenceReasonControllerTest extends UnitHelpers
{
    protected function setUp()
    {
        $this->controller = new AbsenceReasonController();
        parent::setUp();
    }
    
    /**
     * imitate POST request
     */
    public function testCreate()
    {
        $this->request->setMethod('post');
        
        $this->request->getPost()->set('name', 'Name absencereason');
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, true);
    }
    
//public function testGet()
//{
//    $this->request->setMethod('get');
//        $this->routeMatch->setParam('id', $this->CreateAbsenceReason()->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//}
    
}

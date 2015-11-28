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
        
        $this->request->getPost()->set('tere', ['oi'=>'oi']);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, true);
    }
    
//    protected function setUp()
//    {
//        
//    }
//    
//    public function testDummyTest() {
//        $a = 0;
//        $this-> assertEquals(1,$a);
//    }
    
    
}

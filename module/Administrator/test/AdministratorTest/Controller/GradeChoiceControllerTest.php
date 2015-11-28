<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\GradeChoiceController;

class GradeChoiceControllerTest extends UnitHelpers {

    //put your code here
    // protected function setUp(){
    // }
    //public function testDummyTest(){
    //$a=0;
    // $this->assertEquals(1,$a);
    //}
    protected function setUp() {
        $this->controller = new GradeChoiceController();
        parent::setUp();
    }

    /**
     * imitate POST request
     */
    public function testCreate() {
        $this->request->setMethod('post');
        $this->request->getPost()->set("tere", "Maailm");
        $this->request->getPost()->set("Parnu", "Linn");
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);
    }

}

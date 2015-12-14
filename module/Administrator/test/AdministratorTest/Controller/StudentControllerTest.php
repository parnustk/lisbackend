<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\StudentController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);
/**
 * @author marten
 */
class StudentControllerTest extends UnitHelpers
{
    protected function setUp()
    {
        $this->controller = new StudentController();
        parent::setUp();
    }
    //put code here
    public function testCreate()
    {
      $this->request->setMethod('post');
      
      $this->request->getPost()->set("tere", "maailm");
      $this->request->getPost()->set("tere", "maailm");
      
      $result = $this->controller->dispatch($this->request);
      $response = $this->controller->getResponse();
      $this->assertEquals(200, $response->getStatusCode());
      $this->PrintOut($result, true);
      $this->assertEquals(1,$result->success);
    }
}


<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\TeacherController;

class TeacherControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new TeacherController();
        parent::setUp();
    }

    public function testCreate()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, TRUE);
    }

}

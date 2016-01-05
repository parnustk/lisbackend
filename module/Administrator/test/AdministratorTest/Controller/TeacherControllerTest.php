<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\TeacherController;

/**
 * @author juhan
 */
class TeacherControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new TeacherController();
        parent::setUp();
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
        $this->PrintOut($result, false);
    }

}

<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author sander
 */
class SubjectControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectController();
        parent::setUp();
    }

    public function testCreate()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("durationAllAK", "30");
        $this->request->getPost()->set("durationContactAK", "10");
        $this->request->getPost()->set("durationIndependentAK", "20");

        $this->request->getPost()->set("module", $this->CreateModule()->getId());
        
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);
    }

}

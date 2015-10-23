<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\GradingtypeController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author sander
 */
class GradingtypeControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new GradingtypeController();
        parent::setUp();
    }

    public function testCreate()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("gradingType", "Test Tere Maailm");
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateGradingType()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        $this->CreateGradingType();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testUpdate()
    {
        $gradingType = $this->CreateGradingType();

        $nameOld = $gradingType->getGradingType();

        $this->routeMatch->setParam('id', $gradingType->getId());
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            "gradingType" => "Updated"
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\GradingType')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $nameOld, $r->getGradingType()
        );

        $this->PrintOut($result, false);
    }

    public function testDelete()
    {
        $gradingType = $this->CreateGradingType();

        $idOld = $gradingType->getId();

        $this->routeMatch->setParam('id', $gradingType->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //test it is not in the database anymore
        $deletedModule = $this->em
                ->getRepository('Core\Entity\GradingType')
                ->find($idOld);

        $this->assertEquals(null, $deletedModule);
        $this->PrintOut($result, false);
    }

}

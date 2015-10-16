<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\ModuleController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author sander
 */
class ModuleControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new ModuleController();
        parent::setUp();
    }

    public function testCreate()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("gradingType", $this->CreateGradingType()->getId());
//        $this->request->getPost()->set("gradingType", ['id' => $gradingType->getId()]);
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
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

    public function testCreateNoGradingType()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateModule()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        //create one to get first
        $this->CreateModule();
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
        $createdModule = $this->CreateModule();

        $nameOld = $createdModule->getName();
        $codeOld = $createdModule->getCode();
        $durationOld = $createdModule->getDuration();

        $vocationIdOld = $createdModule->getVocation()->getId();
        $moduleTypeOld = $createdModule->getModuleType()->getId();

        $gradingTypesOld = [];
        foreach ($createdModule->getGradingType() as $gType) {
            $gradingTypesOld[] = $gType->getId();
        }

        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $createdModule->getId());

        $this->request->setContent(http_build_query([
            "name" => "Updated",
            'code' => uniqid(),
            'name' => 'Updated',
            'duration' => 888,
            'vocation' => $this->CreateVocation()->getId(),
            'moduleType' => $this->CreateModuleType()->getId(),
            'gradingType' => [
                ['id' => $this->CreateGradingType()->getId()],
                ['id' => $this->CreateGradingType()->getId()]
            ],
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $resultModule = $this->em
                ->getRepository('Core\Entity\Module')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $nameOld, $resultModule->getName()
        );

        $this->assertNotEquals(
                $codeOld, $resultModule->getCode()
        );

        $this->assertNotEquals(
                $durationOld, $resultModule->getDuration()
        );

        $this->assertNotEquals(
                $vocationIdOld, $resultModule->getVocation()->getId()
        );
        $this->assertNotEquals(
                $moduleTypeOld, $resultModule->getModuleType()->getId()
        );
        //test that gradeTypes have beeing updated
        foreach ($resultModule->getGradingType() as $gtU) {
            $this->assertEquals(
                    false, in_array($gtU->getId(), $gradingTypesOld)
            );
        }
         $this->PrintOut($result, false);
    }

    public function testDelete()
    {
        $idOld = $this->CreateModule()->getId();        
        $this->routeMatch->setParam('id', $idOld);
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1, $result->success);

        //test it is not in the database anymore
        $deletedModule = $this->em
                ->getRepository('Core\Entity\Module')
                ->find($idOld);
        
        $this->assertEquals(null, $deletedModule);
        
        $this->PrintOut($result, false);
    }

}

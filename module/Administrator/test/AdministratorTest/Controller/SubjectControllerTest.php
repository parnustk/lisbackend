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
        $this->PrintOut($result, false);
    }

    public function testCreateGradingType()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("durationAllAK", "30");
        $this->request->getPost()->set("durationContactAK", "10");
        $this->request->getPost()->set("durationIndependentAK", "20");

        $this->request->getPost()->set("module", $this->CreateModule()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
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

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateSubject()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        //create one to get first
        $this->CreateSubject();
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
        $created = $this->CreateSubject();

        $codeOld = $created->getCode();
        $nameOld = $created->getName();
        $durationAllAKOld = $created->getDurationAllAK();
        $durationContactAKOld = $created->getDurationContactAK();
        $durationIndependentAKOld = $created->getDurationIndependentAK();
        $moduleIdOld = $created->getModule()->getId();

        $gradingTypesOld = [];
        foreach ($created->getGradingType() as $gType) {
            $gradingTypesOld[] = $gType->getId();
        }

        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $created->getId());
        $this->request->setContent(http_build_query([
            'code' => uniqid(),
            "name" => "Updated",
            'name' => 'Updated',
            'durationAllAK' => 1000,
            'durationContactAK' => 600,
            'durationIndependentAK' => 400,
            'module' => $this->CreateModule()->getId(),
            'gradingType' => [
                ['id' => $this->CreateGradingType()->getId()],
                ['id' => $this->CreateGradingType()->getId()]
            ],
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Subject')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $nameOld, $r->getName()
        );

        $this->assertNotEquals(
                $codeOld, $r->getCode()
        );

        $this->assertNotEquals(
                $durationAllAKOld, $r->getDurationAllAK()
        );

        $this->assertNotEquals(
                $durationContactAKOld, $r->getDurationContactAK()
        );
        $this->assertNotEquals(
                $durationIndependentAKOld, $r->getDurationIndependentAK()
        );
        
        $this->assertNotEquals(
                $moduleIdOld, $r->getModule()->getId()
        );
        //test that gradeTypes have beeing updated
        foreach ($r->getGradingType() as $gtU) {
            $this->assertEquals(
                    false, in_array($gtU->getId(), $gradingTypesOld)
            );
        }
        $this->PrintOut($result, false);
    }
    
    public function testDelete()
    {
        $idOld = $this->CreateSubject()->getId();        
        $this->routeMatch->setParam('id', $idOld);
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1, $result->success);

        //test it is not in the database anymore
        $deletedModule = $this->em
                ->getRepository('Core\Entity\Subject')
                ->find($idOld);
        
        $this->assertEquals(null, $deletedModule);
        
        $this->PrintOut($result, true);
    }

}

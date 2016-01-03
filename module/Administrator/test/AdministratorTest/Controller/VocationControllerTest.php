<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\VocationController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author sander, juhan
 */
class VocationControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new VocationController();
        parent::setUp();
    }

    /**
     * create new with correct data see entity
     */
    public function testCreate()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("name", "Name vocation");
        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("durationEKAP", 120);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    /**
     * create one before getting
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateVocation()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, FALSE);
    }

    /**
     * create one before asking list
     */
    public function testGetList()
    {
        $this->CreateVocation();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, FALSE);
    }

    public function testUpdate()
    {
        //TODO
        //create vocation
        $entity = $this->CreateVocation();
        $id = $entity->getId();

        $nameOld = $entity->getName();
        $codeOld = $entity->getCode();
        $durationEKAPOld = $entity->getDurationEKAP();

        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'name' => 'Updated',
            'code' => uniqid(),
            'durationEKAP' => '456',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $r = $this->em
                ->getRepository('Core\Entity\Vocation')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $nameOld, $r->getName()
        );
        $this->assertNotEquals(
                $codeOld, $r->getCode()
        );
        $this->assertNotEquals(
                $durationEKAPOld, $r->getDurationEKAP()
        );
        $this->PrintOut($result, FALSE);
    }

    public function testDelete()
    {
        $entity = $this->CreateVocation();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Vocation')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }

}

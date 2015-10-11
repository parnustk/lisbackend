<?php

namespace AdministratorTest\Controller;

use AdministratorTest\Bootstrap;
use Administrator\Controller\ModuleController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

//error_reporting(E_ALL | E_STRICT);
//chdir(__DIR__);

/**
 * @author sander
 */
class ModuleControllerTest extends \PHPUnit_Framework_TestCase
{

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new ModuleController();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }

    private function PrintOut($v, $print = false)
    {
        if ($print) {
            echo "\n";
            echo "\t";
            print_r($v);
            echo "\n";
        }
    }

    public function testCreate()
    {
        $this->request->setMethod('post');

        $em = $this->controller->getEntityManager();

        $vocation = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);

        if (!$vocation->validate()) {
            throw new Exception(Json::encode($vocation->getMessages(), true));
        }

        $em->persist($vocation);

        $moduleType = (new \Core\Entity\ModuleType($em))->hydrate([
            'name' => 'ModuleTypeName',
        ]);

        if (!$moduleType->validate()) {
            throw new Exception(Json::encode($moduleType->getMessages(), true));
        }
        $em->persist($moduleType);

        $gradingType = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);

        if (!$gradingType->validate()) {
            throw new Exception(Json::encode($gradingType->getMessages(), true));
        }
        $em->persist($gradingType);
        $em->flush();

        $this->request->getPost()->set("vocation", $vocation->getId());
        $this->request->getPost()->set("moduleType", $moduleType->getId());

        $this->request->getPost()->set("gradingType", $gradingType->getId());
//        $this->request->getPost()->set("gradingType", ['id' => $gradingType->getId()]);

        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result);
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
        $this->PrintOut($result);
    }

    public function testCreateNoGradingType()
    {
        $this->request->setMethod('post');
        $em = $this->controller->getEntityManager();
        $vocation = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);
        if (!$vocation->validate()) {
            throw new Exception(Json::encode($vocation->getMessages(), true));
        }
        $em->persist($vocation);

        $moduleType = new \Core\Entity\ModuleType($em);
        $moduleType->hydrate([
            'name' => 'ModuleTypeName',
        ]);

        if (!$moduleType->validate()) {
            throw new Exception(Json::encode($moduleType->getMessages(), true));
        }
        $em->persist($moduleType);
        $em->flush();

        $this->request->getPost()->set("vocation", $vocation->getId());
        $this->request->getPost()->set("moduleType", $moduleType->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);

        $this->PrintOut($result);
    }

    public function testGet()
    {
        //create one to get first
        $em = $this->controller->getEntityManager();
        $vocation = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);
        if (!$vocation->validate()) {
            $this->PrintOut($vocation->getMessages());
        }
        $em->persist($vocation);
        $moduleType = (new \Core\Entity\ModuleType($em))->hydrate([
            'name' => 'ModuleTypeName',
        ]);
        if (!$moduleType->validate()) {
            $this->PrintOut($moduleType->getMessages());
        }
        $em->persist($moduleType);

        $gradingType = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType->validate()) {
            $this->PrintOut($gradingType->getMessages());
        }
        $em->persist($gradingType);

        $gradingType1 = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType1->validate()) {
            $this->PrintOut($gradingType1->getMessages(), false);
        }
        $em->persist($gradingType1);

        $em->flush();

        $gradingTypes = [
            ['id' => $gradingType->getId()],
            ['id' => $gradingType1->getId()]
        ];

        $this->PrintOut($gradingTypes, false);

        $module = $em->getRepository('Core\Entity\Module')->Create([
            'code' => uniqid(),
            'name' => 'asd',
            'duration' => 12,
            'vocation' => $vocation->getId(),
            'moduleType' => $moduleType->getId(),
            'gradingType' => $gradingTypes,
                ], true);

        $this->PrintOut($module, false);

        $createdModule = $em
                ->getRepository('Core\Entity\Module')
                ->find($module['id']);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $createdModule->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        //create one to get first
        $em = $this->controller->getEntityManager();
        $vocation = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);
        if (!$vocation->validate()) {
            $this->PrintOut($vocation->getMessages());
        }
        $em->persist($vocation);
        $moduleType = (new \Core\Entity\ModuleType($em))->hydrate([
            'name' => 'ModuleTypeName',
        ]);
        if (!$moduleType->validate()) {
            $this->PrintOut($moduleType->getMessages());
        }
        $em->persist($moduleType);

        $gradingType = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType->validate()) {
            $this->PrintOut($gradingType->getMessages());
        }
        $em->persist($gradingType);

        $gradingType1 = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType1->validate()) {
            $this->PrintOut($gradingType1->getMessages(), false);
        }
        $em->persist($gradingType1);

        $em->flush();

        $gradingTypes = [
            ['id' => $gradingType->getId()],
            ['id' => $gradingType1->getId()]
        ];

        $this->PrintOut($gradingTypes, false);

        $module = $em->getRepository('Core\Entity\Module')->Create([
            'code' => uniqid(),
            'name' => 'asd',
            'duration' => 12,
            'vocation' => $vocation->getId(),
            'moduleType' => $moduleType->getId(),
            'gradingType' => $gradingTypes,
                ], true);

        $this->PrintOut($module, false);

        $createdModule = $em
                ->getRepository('Core\Entity\Module')
                ->find($module['id']);

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
        //Create one to update
        $em = $this->controller->getEntityManager();
        $vocation = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);
        if (!$vocation->validate()) {
            $this->PrintOut($vocation->getMessages());
        }
        $em->persist($vocation);
        $moduleType = (new \Core\Entity\ModuleType($em))->hydrate([
            'name' => 'ModuleTypeName',
        ]);
        if (!$moduleType->validate()) {
            $this->PrintOut($moduleType->getMessages());
        }
        $em->persist($moduleType);

        $gradingType = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType->validate()) {
            $this->PrintOut($gradingType->getMessages());
        }
        $em->persist($gradingType);

        $gradingType1 = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType1->validate()) {
            $this->PrintOut($gradingType1->getMessages(), false);
        }
        $em->persist($gradingType1);

        $em->flush();

        $gradingTypes = [
            ['id' => $gradingType->getId()],
            ['id' => $gradingType1->getId()]
        ];

        $gradingTypesOldArray = [
            $gradingType->getId(),
            $gradingType1->getId()
        ];


        $this->PrintOut($gradingTypes, false);

        $module = $em->getRepository('Core\Entity\Module')->Create([
            'code' => uniqid(),
            'name' => 'asd',
            'duration' => 12,
            'vocation' => $vocation->getId(),
            'moduleType' => $moduleType->getId(),
            'gradingType' => $gradingTypes,
                ], true);
        $this->PrintOut($module, false);
        $createdModule = $em
                ->getRepository('Core\Entity\Module')
                ->find($module['id']);

//        foreach ($createdModule->getGradingType() as $gType) {
//            $this->PrintOut($gType->getId(), false);
//        }

        $this->routeMatch->setParam('id', $createdModule->getId());
        $this->request->setMethod('put');

        $vocationU = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'UPDATED',
            'code' => uniqid(),
            'durationEKAP' => 888,
        ]);
        if (!$vocationU->validate()) {
            $this->PrintOut($vocationU->getMessages());
        }
        $em->persist($vocationU);

        $moduleTypeU = (new \Core\Entity\ModuleType($em))->hydrate([
            'name' => 'UPDATED',
        ]);
        if (!$moduleTypeU->validate()) {
            $this->PrintOut($moduleTypeU->getMessages());
        }
        $em->persist($moduleTypeU);

        $gradingTypeU = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'UPDATED',
        ]);
        if (!$gradingTypeU->validate()) {
            $this->PrintOut($gradingTypeU->getMessages());
        }
        $em->persist($gradingTypeU);

        $gradingType1U = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'UPDATED',
        ]);
        if (!$gradingType1U->validate()) {
            $this->PrintOut($gradingType1U->getMessages(), false);
        }
        $em->persist($gradingType1U);

        $em->flush();

        $this->request->setContent(http_build_query([
            "name" => "Updated",
            'code' => uniqid(),
            'name' => 'Updated',
            'duration' => 888,
            'vocation' => $vocationU->getId(),
            'moduleType' => $moduleTypeU->getId(),
            'gradingType' => [
                ['id' => $gradingTypeU->getId()],
                ['id' => $gradingType1U->getId()]
            ],
        ]));
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);

        $this->PrintOut($result->data['gradingType'], false);

//        $this->assertNotEquals($resultModule, $response);


        $resultModule = $em
                ->getRepository('Core\Entity\Module')
                ->find($result->data['id']);

        //test that gradeTypes have beeing updated
        foreach ($resultModule->getGradingType() as $gtU) {
            $this->assertEquals(
                    false, in_array($gtU->getId(), $gradingTypesOldArray)
            );
        }
    }

    public function testDelete()
    {
        //create one to delete first
        $em = $this->controller->getEntityManager();
        $vocation = (new \Core\Entity\Vocation($em))->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);
        if (!$vocation->validate()) {
            $this->PrintOut($vocation->getMessages());
        }
        $em->persist($vocation);
        $moduleType = (new \Core\Entity\ModuleType($em))->hydrate([
            'name' => 'ModuleTypeName',
        ]);
        if (!$moduleType->validate()) {
            $this->PrintOut($moduleType->getMessages());
        }
        $em->persist($moduleType);

        $gradingType = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType->validate()) {
            $this->PrintOut($gradingType->getMessages());
        }
        $em->persist($gradingType);

        $gradingType1 = (new \Core\Entity\GradingType($em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);
        if (!$gradingType1->validate()) {
            $this->PrintOut($gradingType1->getMessages(), false);
        }
        $em->persist($gradingType1);

        $em->flush();

        $gradingTypes = [
            ['id' => $gradingType->getId()],
            ['id' => $gradingType1->getId()]
        ];

        $this->PrintOut($gradingTypes, false);

        $module = $em->getRepository('Core\Entity\Module')->Create([
            'code' => uniqid(),
            'name' => 'asd',
            'duration' => 12,
            'vocation' => $vocation->getId(),
            'moduleType' => $moduleType->getId(),
            'gradingType' => $gradingTypes,
                ], true);

        $this->PrintOut($module, false);

        $createdModule = $em
                ->getRepository('Core\Entity\Module')
                ->find($module['id']);

        $this->routeMatch->setParam('id', $createdModule->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);

        //test it is not in the database anymore
        $deletedModule = $em
                ->getRepository('Core\Entity\Module')
                ->find($module['id']);
        $this->assertEquals(null, $deletedModule);
    }

}

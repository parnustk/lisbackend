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

    public function testCreate()
    {
        $this->request->setMethod('post');

        $em = $this->controller->getEntityManager();

        $vocation = new \Core\Entity\Vocation($em);
        $vocation->hydrate([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12'
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

        $gradingType = new \Core\Entity\GradingType($em);
        $gradingType->hydrate([
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

        $s = (int) $result->success;
        if ($s !== 1) {
            echo "\n--------------------------------------------------------\n";
            print_r($result);
            echo "\n--------------------------------------------------------\n";
        } else {
//            print_r($result);
        }
        $this->assertEquals(1, $s);
    }

//    public function testGet()
//    {
//        $this->request->setMethod('get');
//        $this->routeMatch->setParam('id', '1');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result->msg);
//            echo "\n--------------------------------------------------------\n";
//        } else {
////            print_r($result);
//        }
//        //print_r($s);
//        $this->assertEquals(1, $s);
//    }
//    public function testGetList()
//    {
//
//        $this->request->setMethod('get');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result->msg);
//            echo "\n--------------------------------------------------------\n";
//        } else {
////            print_r($result);
//        }
//        //print_r($s);
//        $this->assertEquals(1, $s);
//    }
//    public function testUpdate()
//    {
//        $this->routeMatch->setParam('id', '1');
//
//        $this->request->setMethod('put');
//
//        $this->request->setContent(http_build_query([
//            "name" => "Ahoi Tere"
//        ]));
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result);
//            echo "\n--------------------------------------------------------\n";
//        } else {
//            //print_r($result);
//        }
//        $this->assertEquals(1, $s);
//    }
//    public function testDelete()
//    {
//        //create one to delete first
//        $em = $this->controller->getEntityManager();
//
//        $sample = new \Core\Entity\ModuleType($em);
//        $sample->hydrate(['name' => 'PHPUNIT']);
//
//        if (!$sample->validate()) {
//            throw new Exception(Json::encode($sample->getMessages(), true));
//        }
//
//        $em->persist($sample);
//        $em->flush($sample);
//
//        $this->routeMatch->setParam('id', $sample->getId());
//        $this->request->setMethod('delete');
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result);
//            echo "\n--------------------------------------------------------\n";
//        } else {
////            print_r($result);
//        }
//        $this->assertEquals(1, $s);
//    }
}

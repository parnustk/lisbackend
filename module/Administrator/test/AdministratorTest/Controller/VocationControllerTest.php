<?php

namespace AdministratorTest\Controller;

use AdministratorTest\Bootstrap;
use Administrator\Controller\VocationController;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

//error_reporting(E_ALL | E_STRICT);
//chdir(__DIR__);

/**
 * @author sander
 */
class SampleControllerTest extends \PHPUnit_Framework_TestCase
{

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new VocationController();
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
    
    /**
     * Dummy test for testclass
     */
    public function testT()
    {
        $this->assertEquals(1, 1);
    }

//    public function testCreate()
//    {
//        $this->request->setMethod('post');
//        
//        //set correct data
//        $this->request->getPost()->set("name", "Test Tere Maailm");
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//
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
//
////    public function testGetList()
////    {
////
////        $this->request->setMethod('get');
////        $result = $this->controller->dispatch($this->request);
////        $response = $this->controller->getResponse();
////        $this->assertEquals(200, $response->getStatusCode());
////        $s = (int) $result->success;
////        if ($s !== 1) {
////            echo "\n--------------------------------------------------------\n";
////            print_r($result->msg);
////            echo "\n--------------------------------------------------------\n";
////        } else {
//////            print_r($result);
////        }
////        //print_r($s);
////        $this->assertEquals(1, $s);
////    }
//
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
}

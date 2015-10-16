<?php

namespace AdministratorTest\Controller;

use AdministratorTest\Bootstrap;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

/**
 * Description of UnitHelpers
 *
 * @author sander
 */
abstract class UnitHelpers extends \PHPUnit_Framework_TestCase
{

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected $em;

    /**
     * Common setup for testing controllers
     */
    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
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
        $this->em = $this->controller->getEntityManager();
    }

    /**
     * Print to terminal
     * @param type $v
     * @param type $print
     */
    protected function PrintOut($v, $print = false)
    {
        if ($print) {
            echo "\n";
            echo "\t";
            print_r($v);
            echo "\n";
        }
    }

    /**
     * 
     * @param array $data | null
     * @return Core\Entity\Vocation
     */
    protected function CreateVocation($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Vocation');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => 'VocationName',
                    'code' => uniqid(),
                    'durationEKAP' => '12',
        ]);
    }

    /**
     * 
     * @param array $data | null
     * @return Core\Entity\ModuleType
     */
    protected function CreateModuleType($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\ModuleType');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => 'ModuleTypeName',
        ]);
    }

    /**
     * 
     * @param array $data | null
     * @return Core\Entity\GradingType
     */
    protected function CreateGradingType($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\GradingType');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'gradingType' => 'GradingTypeName',
        ]);
    }

    /**
     * 
     * @param array $data | null
     * @return Core\Entity\Module
     */
    protected function CreateModule($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Module');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'code' => uniqid(),
                    'name' => 'asd',
                    'duration' => 12,
                    'vocation' => $this->CreateVocation()->getId(),
                    'moduleType' => $this->CreateModuleType()->getId(),
                    'gradingType' => [
                        ['id' => $this->CreateGradingType()->getId()],
                        ['id' => $this->CreateGradingType()->getId()]
                    ],
        ]);
    }

}

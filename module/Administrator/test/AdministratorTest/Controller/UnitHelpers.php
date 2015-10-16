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
     * @return Core\Entity\Vocation
     */
    protected function CreateVocation($data = null)
    {
        if ($data) {
            $vocation = $this->em->getRepository('Core\Entity\Vocation')
                    ->Create($data);

            return $vocation;
        }
        $vocation = $this->em->getRepository('Core\Entity\Vocation')->Create([
            'name' => 'VocationName',
            'code' => uniqid(),
            'durationEKAP' => '12',
        ]);
        
        return $vocation;
        
//        $vocation = (new \Core\Entity\Vocation($this->em))->hydrate([
//            'name' => 'VocationName',
//            'code' => uniqid(),
//            'durationEKAP' => '12',
//        ]);
//
//        if (!$vocation->validate()) {
//            print_r($vocation->getMessages());
//        }
//
//        $this->em->persist($vocation);
//        $this->em->flush();
//
//        return $vocation;
    }

    /**
     * 
     * @return Core\Entity\ModuleType
     */
    protected function CreateModuleType($data = null)
    {
        if ($data) {
            
        }

        $moduleType = (new \Core\Entity\ModuleType($this->em))->hydrate([
            'name' => 'ModuleTypeName',
        ]);

        if (!$moduleType->validate()) {
            print_r($moduleType->getMessages());
        }

        $this->em->persist($moduleType);
        $this->em->flush();

        return $moduleType;
    }

    /**
     * 
     * @return Core\Entity\GradingType
     */
    protected function CreateGradingType($data = null)
    {
        $gradingType = (new \Core\Entity\GradingType($this->em))->hydrate([
            'gradingType' => 'GradingTypeName',
        ]);

        if (!$gradingType->validate()) {
            print_r($gradingType->getMessages());
        }
        $this->em->persist($gradingType);
        $this->em->flush();

        return $gradingType;
    }

    /**
     * 
     * @param array $data | null
     * @return Core\Entity\Module
     */
    protected function CreateModule($data = null)
    {
        if ($data) {
            $module = $this->em->getRepository('Core\Entity\Module')->Create($data);
            return $module;
        }

        $module = $this->em->getRepository('Core\Entity\Module')->Create([
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

        return $module;
    }

}

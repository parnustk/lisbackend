<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;

class IndexController extends AbstractActionController
{
    /**
     * @param EventManagerInterface $events
     */
    public function setEventManager(EventManagerInterface $events)
    {
        //Zend_Layout::getMvcInstance()->setLayout(__DIR__ . '/../view/layout/application.phtml');
        parent::setEventManager($events);
        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            $controller -> layout('layout/application');
        }, 100);
    }


}

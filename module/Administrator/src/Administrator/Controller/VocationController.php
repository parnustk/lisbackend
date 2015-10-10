<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Exception;
use Zend\Json\Json;
use Core\Controller\AbstractBaseController;

class VocationController extends AbstractBaseController
{

    public function indexAction()
    {
        return new ViewModel();
    }

}

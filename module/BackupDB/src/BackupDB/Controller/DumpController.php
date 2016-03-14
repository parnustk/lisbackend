<?php

namespace BackupDB\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DumpController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}


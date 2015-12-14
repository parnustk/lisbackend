<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class SubjectRoundController extends AbstractBaseController
{

    /**
     * POST
     * 
     * method to create new enitty
     */
    public function create($data)
    {
        $s = $this->getServiceLocator()->get('subjectround_service');
        $result = $s->Create($data);
        return new JsonModel($result);
    }

}

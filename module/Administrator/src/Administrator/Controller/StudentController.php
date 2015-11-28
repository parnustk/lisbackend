<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;


/**
 * @author marten
 * method to create new student
 */
class StudentController extends AbstractBaseController
{
    public function create($data) 
    {
        $s = $this->getServiceLocator()->get('student_service');
        $result = $s->Create($data);
        return new JsonModel($result);
    }
}


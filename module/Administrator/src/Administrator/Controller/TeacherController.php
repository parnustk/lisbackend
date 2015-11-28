<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class TeacherController extends AbstractBaseController
{
/**
 * 
 * POST
 * method to create a new entity
 */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('teacher_service')
                        ->Create($data)
        );
    }

}

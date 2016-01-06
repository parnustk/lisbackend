<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class TeacherController extends AbstractBaseController
{

    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('teacher_service')
                        ->Get($id)
        );
    }

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
    /**
     * 
     */
    public function update($id, $data)
    {
         return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('teacher_service')
                        ->Update($id, $data)
        );
    }
    
      public function delete($id)
    {
         return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('teacher_service')
                        ->Delete($id)
        );
    }
}

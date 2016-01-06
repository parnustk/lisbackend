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
    /**
     * GET
     *
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
        $this
                ->getServiceLocator()
                ->get('student_service')
                ->GetList($this->GetParams())
                );
    }
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
                        ->get('student_service')
                        ->Get($id)
        );
    }
    
    public function create($data) 
    {
        $s = $this->getServiceLocator()->get('student_service');
        $result = $s->Create($data);
        return new JsonModel($result);
    }
}


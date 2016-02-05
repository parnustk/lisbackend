<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * 
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;


/**
 * Description of StudentController
 * @author Marten Kähr <marten@kahr.ee>
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
    /**
     * PUT
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('student_service')
                        ->Update($id, $data)
        );
    }
    /**
     * DELETE
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('student_service')
                        ->Delete($id)
        );
    }
}

<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class StudentGroupController extends AbstractBaseController
{

    /**
     * POST
     * 
     * method to create new enitty
     */
    public function create($data)
    {
        $s = $this->getServiceLocator()->get('studentgroup_service');
        $result = $s->Create($data);
        return new JsonModel($result);
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
                        ->get('studentgroup_service')
                        ->Get($id)
        );
    }
    
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
                        ->get('studentgroup_service')
                        ->GetList($this->GetParams())
        );
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
                        ->get('studentgroup_service')
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
                        ->get('studentgroup_service')
                        ->Delete($id)
        );
    }

}

<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class SubjectRoundController extends AbstractBaseController
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
                        ->get('subjectround_service')
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
                        ->get('subjectround_service')
                        ->Get($id)
        );
    }

    /**
     * POST
     * 
     * method to create new enitty
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('subjectround_service')
                        ->Create($data)
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
                        ->get('subjectround_service')
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
                        ->get('subjectround_service')
                        ->Delete($id)
        );
    }

}

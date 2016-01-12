<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Description of GradeChoice
 *
 * @author Arnold
 */
class GradeChoiceController extends AbstractBaseController {

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
                        ->get('gradechoice_service')
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
                        ->get('gradechoice_service')
                        ->Get($id)
        );
    }
    /**
     * <h2>POST
     * 
     * method to create new enitty
     * 
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('gradechoice_service')
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
                        ->get('gradechoice_service')
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
                        ->get('gradechoice_service')
                        ->Delete($id)
        );
    }
}

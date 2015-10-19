<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * @author Juhan
 */
class VocationController extends AbstractBaseController {

    /**
     * POST
     * 
     * @param type $data
     * @return JsonModel
     */
    public function create($data) {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('vocation_service')
                        ->Create($data)
        );
    }

    /**
     * DELETE
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function delete($id) {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('vocation_service')
                        ->Delete($id)
        );
    }

    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id) {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('vocation_service')
                        ->Get($id)
        );
    }

    /**
     * GET
     *
     * @return JsonModel
     */
    public function getList() {
        return new JsonModel($this
                        ->getServiceLocator()
                        ->get('vocation_service')
                        ->GetList()
        );
    }

    /**
     * PUT
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data) {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('vocation_service')
                        ->Update($id, $data)
        );
    }

}

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
                        ->get('vocation')
                        ->Create($data)
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
                        ->get('vocation')
                        ->GetList()
        );
    }

}


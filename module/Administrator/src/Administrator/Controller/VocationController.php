<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   http://creativecommons.org/licenses/by-nc/4.0/legalcode Attribution-NonCommercial 4.0 International
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Juhan
 */
class VocationController extends AbstractBaseController
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
                        ->get('vocation_service')
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
                        ->get('vocation_service')
                        ->Get($id)
        );
    }

    /**
     * POST
     * 
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('vocation_service')
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
                        ->get('vocation_service')
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
                        ->get('vocation_service')
                        ->Delete($id)
        );
    }

}

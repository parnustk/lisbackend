<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Description of AdministratorController
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AdministratorController extends AbstractBaseController
{

    /**
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('administrator_service')
                        ->GetList($this->GetParams())
        );
    }

    /**
     * 
     * @param int $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('administrator_service')
                        ->Get($id)
        );
    }

    /**
     * 
     * @param int $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('administrator_service')
                        ->Create($data)
        );
    }

    /**
     * 
     * @param int $id
     * @param array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('administrator_service')
                        ->Update($id, $data)
        );
    }

    /**
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('administrator_service')
                        ->Delete($id)
        );
    }

}

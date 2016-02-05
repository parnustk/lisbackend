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
 * Description of AdministratorController
 *
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Marten Kähr <marten@kahr.ee>
 * 
 */
class AdministratorController extends AbstractBaseController
{

    /**
     * <h2>GET admin/administrator</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
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
     * <h2>GET admin/administrator/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
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
     * <h2>POST admin/administrator</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * code(string)*
     * lisUser(integer)</code>
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
     * <h2>PUT admin/administrator/:id</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * code(string)*
     * lisUser(integer)</code>
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
     * <h2>DELETE admin/administrator/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
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

<?php

/* 
 * 
 * LIS development
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2016 Lis dev team
 * @license    TODO
 * 
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Rest API access to studentgroup data.
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class StudentGroupController extends AbstractBaseController
{

    /**
     * <h2>POST admin/studentgroup</h2>
     * <h3>Body</h3>
     * <code>name(string)*
     * vocation(integer)</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        $s = $this->getServiceLocator()->get('independentwork_service');
        $result = $s->Create($data);
        return new JsonModel($result);
    }
    
    /**
     * <h2>GET admin/studentgroup/:id</h2>
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
                        ->get('independentwork_service')
                        ->Get($id)
        );
    }
    
    /**
     * <h2>GET admin/studentgroup</h2>
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
                        ->get('independentwork_service')
                        ->GetList($this->GetParams())
        );
    }
    
    /**
     * <h2>PUT admin/studentgroup/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>name(string)*
     * vocation(integer)*</code>
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
                        ->get('independentwork_service')
                        ->Update($id, $data)
        );
    }
    
    /**
     * <h2>DELETE admin/studentgroup/:id</h2>
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
                        ->get('independentwork_service')
                        ->Delete($id)
        );
    }

}
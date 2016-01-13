<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Description of GradeChoiceController
 *
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class GradeChoiceController extends AbstractBaseController {

    /**
     * <h2>POST admin/gradechoice</h2>
     * <h3>Body</h3>
     * <code>name(string)*
     * vocation(integer)</code>
     * 
     * @param array $data
     * @return JsonModel
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
     * <h2>GET admin/gradechoice/:id</h2>
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
                        ->get('gradechoice_service')
                        ->Get($id)
        );
    }
    
    /**
     * <h2>GET admin/gradechoice</h2>
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
                        ->get('gradechoice_service')
                        ->GetList($this->getParams())
        );
    }
    
    /**
     * <h2>PUT admin/gradechoice/:id</h2>
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
                        ->get('gradechoice_service')
                        ->Update($id, $data)
        );
    }
    
    /**
     * <h2>DELETE admin/gradechoice/:id</h2>
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
                        ->get('gradechoice_service')
                        ->Delete($id)
        );
    }
}
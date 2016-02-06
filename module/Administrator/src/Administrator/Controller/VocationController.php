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
     *
     * @var type 
     */
    protected $service = 'vocation_service';

    /**
     * <h2>GET admin/vocation</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return parent::getList();
    }

    /**
     * <h2>GET admin/vocation/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return parent::get($id);
    }

    /**
     * <h2>POST admin/vocation</h2>
     * <h3>Body</h3>
     * <code>name(string)*
     * code(string)*
     * durationEKAP(string)*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT admin/vocation/:id</h2>
     * <h3>Body</h3>
     * <code>name(string)*
     * code(string)*
     * durationEKAP(string)*</code>
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
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
        return parent::delete($id);
    }

}

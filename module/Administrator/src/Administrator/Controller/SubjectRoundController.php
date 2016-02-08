<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Rest API access to subjectround data.
 * 
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRoundController extends AbstractBaseController
{
    /**
     *
     * @var type 
     */
    protected $service = 'subjectround_service';

    /**
     * <h2>GET admin/subjectround</h2>
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
     * <h2>GET admin/subjectround/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function get($id)
    {
        return parent::get($id);
    }

    /**
     * <h2>POST admin/subjectround</h2>
     * <h3>Body</h3>
     * <code>subject(integer)*
     * studentGroup(integer)*
     * teacher(array) [ { id(integer) } ] ]*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
         return parent::create($data);
    }

    /**
     * <h2>PUT admin/subjectround/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>subject(integer)*
     * studentGroup(integer)*
     * teacher(array) [ { id(integer) } ] ]*</code>
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
     * <h2>DELETE admin/subjectround/:id</h2>
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

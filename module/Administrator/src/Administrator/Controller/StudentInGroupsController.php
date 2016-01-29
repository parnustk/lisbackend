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
 * Rest API access to independentwork data.
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class StudentInGroupsController extends AbstractBaseController
{

    protected $service = 'studentingroups_service';

    /**
     * <h2>POST admin/studentingroups</h2>
     * <h3>Body</h3>
     * <code>duedate(datetime)*
     * description(string)*
     * durationAK(integer)*
     * subjectRound(integer)*
     * teacher(integer)*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>GET admin/studentingroups/:id</h2>
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
     * <h2>GET admin/studentingroups</h2>
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
     * <h2>PUT admin/studentingroups/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>duedate(datetime)*
     * description(string)*
     * durationAK(integer)*
     * subjectRound(integer)*
     * teacher(integer)*</code>
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
     * <h2>DELETE admin/studentingroups/:id</h2>
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
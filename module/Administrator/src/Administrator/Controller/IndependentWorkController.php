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

use Core\Controller\AbstractAdministratorBaseController as Base;

/**
 * Rest API access to independentwork data.
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class IndependentWorkController extends Base
{

    /**
     *
     * @var string
     */
    protected $service = 'independentwork_service';

    /**
     * <h2>POST admin/independentwork</h2>
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
        return parent::notAllowed();
    }

    /**
     * <h2>GET admin/independentwork/:id</h2>
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
     * <h2>GET admin/independentwork</h2>
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
     * <h2>PUT admin/independentwork/:id</h2>
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
        return parent::notAllowed();
    }

    /**
     * <h2>DELETE admin/independentwork/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return parent::notAllowed();
    }

}

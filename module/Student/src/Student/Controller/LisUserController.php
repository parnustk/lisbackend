<?php

/**
 *
 * Licence of Learning Info System (LIS)
 *
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 *
 */
namespace Student\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractAdministratorBaseController as Base;

/**
 * Rest API access to superadmin data.
 *
 * @author Kristen Sepp <seppkristen@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LisUserController extends Base
{

    /**
     *
     * @var string
     */
    protected $service = 'superadmin_service';

    /**
     * <h2>GET admin/student</h2>
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
     * <h2>GET admin/student/:id</h2>
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
     * <h2>POST admin/student</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * personalCode(string)*
     * email(string)*
     * </code>
     * @param int $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT admin/student/:id</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * personalCode(string)*
     * email(string)*</code>
     * @param int $id
     * @param array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * <h2>DELETE admin/student/:id</h2>
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
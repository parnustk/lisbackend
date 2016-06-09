<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Administrator\Controller;

use Core\Controller\AbstractAdministratorBaseController as Base;

/**
 * Description of AdministratorController
 *
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Marten Kähr <marten@kahr.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * 
 */
class AdministratorController extends Base
{

    /**
     *
     * @var type 
     */
    protected $service = 'administrator_service';
    
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
        return parent::getList();
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
        return parent::get($id);
    }

    /**
     * <h2>POST admin/administrator</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * name(string)*
     * email(string)*
     * personalCode(string)*</code>
     * @param int $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT admin/administrator/:id</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * name(string)*
     * email(string)*
     * personalCode(string)*</code>
     * @param int $id
     * @param array $data
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

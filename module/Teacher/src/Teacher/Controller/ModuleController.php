<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Teacher\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractTeacherBaseController as Base;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleController extends Base
{

    /**
     *
     * @var type 
     */
    protected $service = 'module_service';

    /**
     * <h2>GET student/module</h2>
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
     * <h2>GET student/module/:id</h2>
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
     * <h2>POST student/module</h2>
     * <h3>Body</h3>
     * <code> name(string)*
     * duration(integer)*
     * code(string)*
     * vocation(integer)*
     * moduleType(integer)*
     * gradingType(integer)*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::notAllowed();
    }

    /**
     * <h2>PUT student/module/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code> name(string)*
     * duration(integer)*
     * code(string)*
     * vocation(integer)*
     * moduleType(integer)*
     * gradingType(integer)*</code>
     * @param int $id
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::notAllowed();
    }

    /**
     * <h2>DELETE student/module/:id</h2>
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

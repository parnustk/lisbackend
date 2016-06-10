<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractAdministratorBaseController as Base;

/**
 * Description of TeacherController
 *
 * @author Juhan Kõks <juhankoks@gmail.com>,
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class TeacherController extends Base
{

    /**
     *
     * @var string 
     */
    protected $service = 'teacher_service';

    /**
     * <h2>GET admin/teacher/:id</h2>
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
     * <h2>GET admin/teacher</h2>
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
     * <h2>POST admin/teacher</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
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
     * <h2>PUT admin/teacher/:id</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
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
     * <h2>DELETE admin/teacher/:id</h2>
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

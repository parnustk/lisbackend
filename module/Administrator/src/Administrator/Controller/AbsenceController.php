<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractAdministratorBaseController as Base;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AbsenceController extends Base
{

    /**
     *
     * @var type 
     */
    protected $service = 'absence_service';

    /**
     * <h2>GET admin/absence</h2>
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
     * <h2>GET admin/absence/:id</h2>
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
     * <h2>POST admin/absence</h2>
     * <h3>Body</h3>
     * <code> description(string)*
     * absenceReason(integer)
     * student(integer)*
     * contactLesson(integer)* </code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT admin/absence/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>description(string)*
     * absenceReason(integer)
     * student(integer)*
     * contactLesson(integer)* </code>
     * @param type $id
     * @param type $data
     * @return type
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * <h2>DELETE admin/absence/:id</h2>
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

<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Student\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractStudentBaseController as Base;

/**
 * Restrictions for student role:
 * 
 * YES getList - OWN RELATED
 * YES get - OWN RELATED
 * YES create - OWN RELATED CREATED
 * YES update - OWN CREATED ?PERIOD
 * YES delete - OWN CREATED ?PERIOD
 * 
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
     * <h2>GET student/absence</h2>
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
     * <h2>GET student/absence/:id</h2>
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
     * <h2>POST student/absence</h2>
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
     * <h2>PUT student/absence/:id</h2>
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
     * <h2>DELETE student/absence/:id</h2>
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
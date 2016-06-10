<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Teacher\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractTeacherBaseController as Base;

/**
 * Rest API access to independentwork data.
 *
 * @author Marten Kähr <marten@kahr.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class IndependentWorkController extends Base
{

    /**
     * @var string 
     */
    protected $service = 'independentwork_service';

    /**
     * <h2>GET teacher/independentwork</h2>
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
     * <h2>GET teacher/independentwork/:id</h2>
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
     * <h2>POST teacher/independentwork</h2>
     * <h3>Body</h3>
     * <code>duedate(datetime)*
     * name(string)*
     * description(string)*
     * durationAK(integer)*
     * subjectRound(integer)*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT teacher/independentwork/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>duedate(datetime)*
     * name(string)*
     * description(string)*
     * durationAK(integer)*
     * subjectRound(integer)*</code>
     * @param int $id
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * <h2>DELETE teacher/independentwork/:id</h2>
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

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectController extends AbstractBaseController
{

    protected $service = 'subject_service';
    
    /**
     * <h2>GET admin/subject</h2>
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
     * <h2>POST admin/subject</h2>
     * <h3>Body</h3>
     * <code> code(string)*
     * name(string)*
     * durationAllAK(integer)*
     * durationContactAK(integer)*
     * durationIndependentAK(intiger)*
     * module(int)*
     * gradingType(array) [ { id(integer) } ] ]*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>GET admin/subject/:id</h2>
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
     * <h2>PUT admin/subject/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code> code(string)*
     * name(string)*
     * durationAllAK(integer)*
     * durationContactAK(integer)*
     * durationIndependentAK(intiger)*
     * module(int)*
     * gradingType(array) [ { id(integer) } ] ]*</code>
     * @param int $id
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * <h2>DELETE admin/subject/:id</h2>
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

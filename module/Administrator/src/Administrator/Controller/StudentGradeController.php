<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * @author    Eleri Apsolon <eleri.apsolon@gmail.com>
 */

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * StudentGradeController
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentGradeController extends AbstractBaseController
{

    /**
     *
     * @var type 
     */
    protected $service = 'studentgrade_service';

    /**
     * <h2>GET admin/studentgrade</h2>
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
     * <h2>GET admin/studentgrade/:id</h2>
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
     * <h2>POST admin/studentgrade</h2>
     * <h3>Body</h3>
     * <code> notes(string)
     * student(integer)*
     * gradeChoice(integer)*
     * teacher(intiger)*
     * independentWork(integer)
     * module(intiger)
     * subjectRound(intiger)
     * contactLesson(intiger)</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT admin/studentgrade/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code> notes(string)
     * student(integer)*
     * gradeChoice(integer)*
     * teacher(intiger)*
     * independentWork(integer)
     * module(intiger)
     * subjectRound(intiger)
     * contactLesson(intiger)</code>
     * @param int $id
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * <h2>DELETE admin/studentgrade/:id</h2>
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

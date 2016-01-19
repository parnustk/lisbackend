<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
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
}

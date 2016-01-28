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
 * Rest API access to absencereason data.
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceReasonController extends AbstractBaseController
{

    /**
     *
     * @var type 
     */
    protected $service = 'absencereason_service';

    /**
     * <h2>GET admin/absencereason</h2>
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
     * <h2>GET admin/absencereason/:id</h2>
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
     * <h2>POST admin/absencereason</h2>
     * <h3>Body</h3>
     * <code>name(string)*</code>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * <h2>PUT admin/absencereason/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>name(string)*</code>
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }

    /**
     * <h2>DELETE admin/absencereason/:id</h2>
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

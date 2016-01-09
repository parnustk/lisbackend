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
 * Rest API access to absencereason data.
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceReasonController extends AbstractBaseController
{

    /**
     * <h1>GET</h1>
     * <h3>URL PARAMETERS</h3><br>
     * <code>limit(integer)
     * page(integer)</code><br>
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->GetList($this->getParams())
        );
    }

    /**
     * <h1>GET</h1><br>
     * <h3>URL PARAMETERS</h3><br>
     * <code>id(integer)</code><br>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->get($id)
        );
    }

    /**
     * <h1>POST</h1><br>
     * <h3>BODY</h3><br>
     * <code>name(string)</code><br>
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->Create($data)
        );
    }

    /**
     * <h1>PUT</h1><br>
     * <h3>URL PARAMETERS</h3><br>
     * <code>id(integer)</code><br>
     * <h3>BODY</h3><br>
     * <code>name(string)</code><br>
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->Update($id, $data)
        );
    }

    /**
     * <h1>DELETE</h1><br>
     * <h3>URL PARAMETERS</h3><br>
     * <code>id(integer)</code><br>
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->Delete($id)
        );
    }

}

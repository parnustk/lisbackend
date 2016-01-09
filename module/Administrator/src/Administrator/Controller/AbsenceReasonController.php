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
     * ###GET<br>
     * ####URL PARAMETERS<br>
     * <i>limit(integer)</i><br>
     * <i>page(integer)</i><br>
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
     * ###GET<br>
     * ####URL PARAMETERS<br>
     * <b>id(integer)</b><br>
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
     * ###POST<br>
     * ####BODY<br>
     * <b>subject(integer)</b><br>
     * <b>studentGroup(integer)</b><br>
     * <b>teacher(array) [ { id(integer) } ] ]</b><br>
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
     * ###PUT<br>
     * ####URL PARAMETERS<br>
     * <b>id(integer)</b><br>
     * ####BODY<br>
     * <i>subject(integer)</i><br>
     * <i>studentGroup(integer)</i><br>
     * <i>teacher(array) [ { id(integer) } ] ]</i><br>
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
     * ###DELETE<br>
     * ####URL PARAMETERS<br>
     * <b>id(integer)</b><br>
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

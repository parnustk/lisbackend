<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Rest API access to subjectround data.
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   TODO
 * @author Sander Mets <sandermets0@gmail.com>
 */
class SubjectRoundController extends AbstractBaseController
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
                        ->get('subjectround_service')
                        ->GetList($this->GetParams())
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
                        ->get('subjectround_service')
                        ->Get($id)
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
                        ->get('subjectround_service')
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
                        ->get('subjectround_service')
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
                        ->get('subjectround_service')
                        ->Delete($id)
        );
    }

}

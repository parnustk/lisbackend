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
 * Description of AbsenceController
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceController extends AbstractBaseController
{

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
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absence_service')
                        ->GetList($this->GetParams())
        );
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
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absence_service')
                        ->Get($id)
        );
    }

    /**
     * <h2>POST admin/absence</h2>
     * <h3>Body</h3>
     * <code> description(string)*
      absenceReason(integer)*
      student(integer)*
      contactLesson(integer)* </code>
     * 
     * @param array $description
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absence_service')
                        ->Create($data)
        );
    }

    /**
     * <h2>PUT admin/absence/:id</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)*</code>
     * <h3>Body</h3>
     * <code>description(string)*
      absenceReason(integer)*
      student(integer)*
      contactLesson(integer)* </code>
     * @param type $id
     * @param type $description
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absence_service')
                        ->Update($id, $data)
        );
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
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absence_service')
                        ->Delete($id)
        );
    }

}

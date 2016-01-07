<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * @author sander
 */
class SubjectRoundController extends AbstractBaseController
{

    /**
     * GET
     * HTTP(S) params:
     * array(
     *      limit: int
     *      page: int
     *      ...TODO
     * )
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
     * GET
     * HTTP(S) params:
     *      *id: int
     * 
     * @param type $id
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
     * POST
     * 
     * HTTP(S) body:
     * Array
     *   (
     *       *[subject] => int
     *       *[studentGroup] => int
     *       *[teacher] => Array
     *           (
     *               [0] => Array
     *                   (
     *                       *[id] => int
     *                   )
     *
     *               [1] => Array
     *                   (
     *                       [id] => int
     *                   )
     *
     *           )
     *
     *   )
     *
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
     * PUT
     * HTTP(S) parameters:
     *      id: int
     * 
     * HTTP(S) body:
     * Array
     *   (
     *       [subject] => int
     *       [studentGroup] => int
     *       [teacher] => Array
     *           (
     *               [0] => Array
     *                   (
     *                       [id] => int
     *                   )
     *
     *               [1] => Array
     *                   (
     *                       [id] => int
     *                   )
     *
     *           )
     *
     *   )
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
     * DELETE
     * params:
     *      id: int
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

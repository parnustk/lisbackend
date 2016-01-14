<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class TeacherController extends AbstractBaseController
{

    /**
     * <h2>GET admin/teacher/:id</h2>
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
                        ->get('teacher_service')
                        ->Get($id)
        );
    }

    /**
     * <h2>GET admin/teacher</h2>
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
                        ->get('teacher_service')
                        ->GetList()
        );
    }

    /**
     * <h2>POST admin/teacher</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * code(string)*
     * lisUser(integer)</code>
     * @param int $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('teacher_service')
                        ->Create($data)
        );
    }

    /**
     * <h2>PUT admin/teacher/:id</h2>
     * <h3>Body</h3>
     * <code>firstName(string)*
     * lastName(string)*
     * code(string)*
     * lisUser(integer)</code>
     * @param int $id
     * @param array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('teacher_service')
                        ->Update($id, $data)
        );
    }

    /**
     * <h2>DELETE admin/teacher/:id</h2>
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
                        ->get('teacher_service')
                        ->Delete($id)
        );
    }

}

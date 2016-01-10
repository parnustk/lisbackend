<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

class RoomController extends AbstractBaseController
{
    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('room_service')
                        ->Get($id)
        );
    }
    /**
     * POST
     * 
     * method to create new enitty
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('room_service')
                        ->Create($data)
        );
    }
    
    public function update($id, $data)
    {
         return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('room_service')
                        ->Update($id, $data)
        );
    }
    
    public function delete($id)
    {
         return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('room_service')
                        ->Delete($id)
        );
    }
}

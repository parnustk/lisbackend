<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
  * Room Controller
  * 
  * @author Alar Aasa <alar@alaraasa.ee>
  */


class RoomController extends AbstractBaseController
{
    
        /**
     * <h2>GET admin/room</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('room_service')
                        ->GetList()
        );
    }
    
    /**
     * <h2>GET admin/room</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
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
     * <h2>POST admin/room</h2>
     * <h3>Body</h3>
     * <code>name(string)</code>
     * @param int @data
     * @return JsonModel
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
    
     /**
     * <h2>PUT admin/room/id</h2>
     * <h3>Body</h3>
     * <code>name(string)</code>
     * @return JsonModel
     */
    public function update($id, $data)
    {
         return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('room_service')
                        ->Update($id, $data)
        );
    }
    
    /**
     * <h2>DELETE administrator/room</h2>
     * <h3>URL Parameters</h3>
     * <code>id(integer)</code>
     * @return JsonModel
     */
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

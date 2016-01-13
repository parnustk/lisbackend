<?php

namespace Core\Service;

use Exception;

class RoomService extends AbstractBaseService {

    /**
     * 
     * @param array $params
     * @param stdClass|NULL $extra
     * @return array
     */
    public function GetList()
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Rooms')
                        ->GetList(true)
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
    
    /**
     * 
     * @param array $data
     * @return type
     */
    public function Create($data) 
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Rooms')
                        ->Create($data, true)
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
    
        /**
     * 
     * @param int $id
     * @return array
     */
    public function Get($id)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Rooms')
                        ->Get($id, true)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
    
    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Update($id, $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Rooms')
                        ->Update($id, $data, true)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
    
      /**
     * 
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Delete($id)
    {
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Rooms')
                        ->Delete($id)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
}

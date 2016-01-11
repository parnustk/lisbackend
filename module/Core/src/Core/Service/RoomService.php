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
    public function GetList($params)
    {
        try {

            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\Rooms')
                    ->GetList($params);

            $p->setItemCountPerPage($params['limit']);
            $p->setCurrentPageNumber($params['page']);
            
            
            $params['itemCount'] = $p->getTotalItemCount();
            $params['pageCount'] = $p->count();

            return [
                'success' => true,
                'params' => $params,
                'data' => (array) $p->getCurrentItems(),
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
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Get($id, $extra = null)
    {
        $Id = (int) $id;
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Rooms')
                        ->Get($Id, true, $extra)
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

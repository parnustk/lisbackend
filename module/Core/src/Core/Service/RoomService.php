<?php

namespace Core\Service;

use Exception;

class RoomService extends AbstractBaseService {

    /**
     * 
     * @param array $data
     * @return type
     */
    public function Create($data) {
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

}

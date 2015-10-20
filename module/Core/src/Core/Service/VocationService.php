<?php

namespace Core\Service;

use Exception;

/**
 * Testing Service set up. Remove later on.
 * @author Juhan
 */
class VocationService extends AbstractBaseService {

    /**
     * 
     * @return type
     */
    public function Get($id) {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Vocation')
                        ->find($id, true)
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
     * @return type
     */
    public function GetList() {
        try {
            $r = $this->getEntityManager()
                    ->getRepository('Core\Entity\Vocation')
                    ->GetList();
            return [
                'success' => false,
                'data' => $r
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
     * @param type $id
     * @return type
     */
    public function Delete($id) {
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Vocation')
                        ->Delete($id)
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
     * @throws Exception
     */
    public function Create($data) {
        try {
            $sample = $this->getEntityManager()
                    ->getRepository('Core\Entity\Vocation')
                    ->Create($data);

            return [
                'success' => true,
                'data' => $sample->getArrayCopy()
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

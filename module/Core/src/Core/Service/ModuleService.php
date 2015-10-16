<?php

namespace Core\Service;

use Exception;

/**
 * Teting Service set up. Remove later on.
 * @author sander
 */
class ModuleService extends AbstractBaseService
{

    /**
     * 
     * @return type
     */
    public function Get($id)
    {
        try {
            $r = $this->getEntityManager()
                    ->getRepository('Core\Entity\Module')
                    ->Get($id, true);
            return [
                'success' => true,
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
     * @return type
     */
    public function GetList()
    {
        try {
            $r = $this->getEntityManager()
                    ->getRepository('Core\Entity\Module')
                    ->GetList(true);
            return [
                'success' => true,
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
     * @param array $data
     * @throws Exception
     */
    public function Create(array $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Module')
                        ->Create($data, true)
            ];
        } catch (\Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function Update($id, $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Module')
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
     * @return type
     */
    public function Delete($id)
    {
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Module')
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

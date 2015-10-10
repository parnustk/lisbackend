<?php

namespace Core\Service;

use Exception;

/**
 * @author sander
 */
class GradingTypeService extends AbstractBaseService
{

    /**
     * 
     * @return type
     */
    public function Get($id)
    {
        try {
            $r = $this->getEntityManager()
                    ->getRepository('Core\Entity\GradingType')
                    ->find($id);
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
                    ->getRepository('Core\Entity\GradingType')
                    ->GetList();
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
            $sample = $this->getEntityManager()
                    ->getRepository('Core\Entity\GradingType')
                    ->Create($data);

            return [
                'success' => true,
                'data' => $sample->getArrayCopy()
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
            $sample = $this->getEntityManager()
                    ->getRepository('Core\Entity\GradingType')
                    ->Update($id, $data);

            return [
                'success' => true,
                'data' => $sample->getArrayCopy()
            ];
        } catch (\Exception $ex) {

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
            $this->getEntityManager()
                    ->getRepository('Core\Entity\GradingType')
                    ->Delete($id);
            return [
                'success' => true
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

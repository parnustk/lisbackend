<?php

namespace Core\Service;

use Exception;

/**
 * Teting Service set up. Remove later on.
 * @author sander
 */
class VocationService extends AbstractBaseService
{

    /**
     * 
     * @return type
     */
    public function GetList()
    {
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
     * @param array $data
     * @throws Exception
     */
    public function Create($data)
    {
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

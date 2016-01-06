<?php

namespace Core\Service;

use Exception;

/**
 * Description of AbsenceReasonService
 *
 * @author eleri
 */
class AbsenceReasonService extends AbstractBaseService
{

    /**
     * 
     * @param stdClass $params
     * @return array
     */
    public function Create(array $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\AbsenceReason')
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

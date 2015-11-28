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
        return [
            'success' => true,
            $data
        ];
    }

}

<?php

namespace Core\Service;

use Exception;

/**
 * @author juhan
 */
class TeacherService extends AbstractBaseService
{
    /*
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
                        ->getRepository('Core\Entity\Teacher')
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

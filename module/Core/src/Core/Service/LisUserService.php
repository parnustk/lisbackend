<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Service;

use Exception;

/**
 * Description of LisUserService
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LisUserService extends AbstractBaseService
{

    /**
     * 
     * @param array $data
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Create($data, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\LisUser')
                        ->Create($data, true, $extra)
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

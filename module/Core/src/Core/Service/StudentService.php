<?php

namespace Core\Service;

use Exception;

/*
 * @author marten
 */

class StudentService extends \Core\Service\AbstractBaseService
{

    public function Create(array $data)
    {
        return [
            'success' => true,
            $data
        ];
    }

}

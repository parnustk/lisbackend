<?php

namespace Core\Service;

use Exception;

class GroupService extends AbstractBaseService {

    /**
     * 
     * @param array $data
     * @return type
     */
    public function Create(array $data) {
        return [
            'success' => true,
            $data
        ];
    }

}

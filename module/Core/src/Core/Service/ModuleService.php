<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Service;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleService extends AbstractBaseService
{

    /**
     *
     * @var type 
     */
    protected $baseEntity = 'Core\Entity\Module';
    
    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $extra
     * @return type
     */
    public function Update($id, $data, $extra = null)
    {
        return parent::Update($id, $data, $extra);
    }

}

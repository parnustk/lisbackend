<?php

/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

namespace Core\Service;

/**
 * Description of StudentService
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class SuperAdminService extends AbstractBaseService
{
    /**
     *
     * @var string 
     */
    protected $baseEntity = 'Core\Entity\LisUser';

}
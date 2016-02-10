<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Controller;

/**
 * Application ACL resolves by this layer
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
abstract class AbstractTeacherBaseController extends AbstractBaseController
{

    /**
     *
     * @var string 
     */
    protected $role = 'teacher';
    
    /**
     *
     * @var Core\Entity\LisUser|null
     */
    protected $lisUser = null;

}

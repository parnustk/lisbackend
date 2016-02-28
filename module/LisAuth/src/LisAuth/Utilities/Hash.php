<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuth\Utilites;

use Zend\Crypt\Password\Bcrypt;

/**
 * Contains static function(s)
 * for hashing password
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class Hash
{

    /**
     * Password Cost
     *
     * The number represents the base-2 logarithm of the iteration count used for
     * hashing. Default is 14 (about 10 hashes per second on an i5).
     *
     * Accepted values: integer between 4 and 31
     * @var type 
     */
    private static $passwordCost = 4;

    /**
     * To hash function
     * 
     * @param string $password plain password
     * @return string hash
     */
    public static function passwordToHash($password)
    {
        return (new Bcrypt)
                        ->setCost(self::$passwordCost)
                        ->create($password);
    }

}

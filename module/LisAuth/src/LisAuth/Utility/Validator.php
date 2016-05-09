<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuth\Utility;

use Zend\Validator\EmailAddress;
use Zend\Validator\Regex;
use Exception;
use Zend\Json\Json;
use Zend\Filter\StringTrim;

/**
 * Contains static function(s)
 * for common input validation
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class Validator
{

    /**
     * Trims and validates email
     * 
     * @param string $email
     * @return string
     * @throws Exception
     */
    public static function validateEmail($email)
    {
        $validator = new EmailAddress();
        if (!$validator->isValid((new StringTrim())->filter($email))) {
            throw new Exception(Json::encode($validator->getMessages()));
        }
        return $email;
    }

    /**
     * Trims and validates password against regex
     * 
     * @param string $password
     * @return string
     * @throws Exception
     */
    public static function validatePassword($password)
    {
        $validator = new Regex([
            'pattern' => '/((?=.*\d)(?=.*[a-zA-Z]).{8,20})/U'
        ]);
        if (!$validator->isValid((new StringTrim())->filter($password))) {
            throw new Exception(Json::encode($validator->getMessages()));
        }
        return $password;
    }

}

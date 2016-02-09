<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Entity\CustomType;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zend\Crypt\BlockCipher;

/**
 * Type that maps an SQL VARCHAR to a PHP decrypted string.
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class EncryptedString extends StringType
{

    /**
     * Constant containing name
     */
    const TYPE_NAME = 'encryptedstring';

    /**
     * Key for crypting
     * TODO get it from config
     */
    const KEY = 'x3xuKEA5+Ec7cY:_';

    /**
     * 
     * @param string $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        try {
            $v = parent::convertToDatabaseValue($value, $platform);
            return BlockCipher::factory('mcrypt', array('algo' => 'aes'))
                            ->setKey(self::KEY)
                            ->encrypt($v);
        } catch (\Exception $ex) {
            return $value;
        }
    }

    /**
     * 
     * @param string $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        try {
            $v = parent::convertToPHPValue($value, $platform);
            return BlockCipher::factory('mcrypt', array('algo' => 'aes'))
                            ->setKey(self::KEY)
                            ->decrypt($v);
        } catch (\Exception $ex) {
            return $value;
        }
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return self::TYPE_NAME;
    }

}

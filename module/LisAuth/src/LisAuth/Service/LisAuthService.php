<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace LisAuth\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use LisAuth\Utilites\Validator;
use LisAuth\Utilites\Hash;
use Exception;

/**
 * LisAuthService. Checks for identity
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LisAuthService implements ServiceManagerAwareInterface
{

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     *
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * 
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * 
     * @param ServiceManager $serviceManager
     * @return \LisAuth\Service\LisRegisterService
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * 
     * @param EntityManager $entityManager
     * @return \LisAuth\Service\LisRegisterService
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * 
     * @param array $data
     * @param string $role
     * @return array
     */
    public function logIn($data, $role)
    {
        $r = [];
        try {
            $email = \LisAuth\Utilites\Validator::validateEmail($data['email']);
            $password = Validator::validatePassword($data['password']);
            $passwordHash = Hash::passwordToHash($password);

            print_r($email);
            print_r($passwordHash);
            die;
        } catch (Exception $ex) {
            
        }


        //check if exists

        /*

          [email] => 56d2d1556234e@test.ee
          [password] => 56d2d1556235b
         */

        //check if already logged in
        //set to session if needed

        return $r;
    }

}

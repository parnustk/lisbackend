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
use LisAuth\Utility\Validator;
use LisAuth\Utility\Hash;
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
            $email = Validator::validateEmail($data['email']);
            $password = Validator::validatePassword($data['password']);
            
            $adminUser = $this->getEntityManager()
                    ->getRepository('Core\Entity\Administrator')
                    ->FetchAdministratorUser($email);

            /*
              [id] => 403
              [lisUser] => Array
              (
              [id] => 552
              [password] => $2y$04$h9d2ZaHEI9GeYou3rN5pXesNNBIH2hW6csfquPSrJ557YIgqBKAFm
              )
             */
            $hash = $adminUser['lisUser']['password'];
            Hash::verifyHash($password, $hash);
            
            
            die('so far so good'."\n");
        } catch (Exception $ex) {
            $r = [
                'success' => false,
                'message' => $ex->getMessage()
            ];
            print_r($r);
            die;
        }

        return $r;
    }

}

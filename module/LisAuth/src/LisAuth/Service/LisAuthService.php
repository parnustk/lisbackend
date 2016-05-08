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
use Zend\Authentication\Storage;
use Zend\Session\Container as SessionContainer;

/**
 * LisAuthService. Checks for identity
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LisAuthService implements Storage\StorageInterface, ServiceManagerAwareInterface
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
     * @var Storage\StorageInterface
     */
    protected $storage;

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
     * Returns the persistent storage handler
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return Storage\StorageInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Storage\Session('LisAuthService'));
        }

        return $this->storage;
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
     * Sets the persistent storage handler
     *
     * @param  Storage\StorageInterface $storage
     * @return AbstractAdapter Provides a fluent interface
     */
    public function setStorage(Storage\StorageInterface $storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If it is impossible to determine whether
     * storage is empty or not
     * @return boolean
     */
    public function isEmpty()
    {
        if ($this->getStorage()->isEmpty()) {
            return true;
        }
        $identity = $this->getStorage()->read();
        if ($identity === null) {
            $this->clear();
            return true;
        }

        return false;
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If reading contents from storage is impossible
     * @return mixed
     */
    public function read()
    {
        $this->getStorage()->read();
    }

    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents)
    {
        $this->getStorage()->write($contents);
    }

    /**
     * Clears contents from storage
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If clearing contents from storage is impossible
     * @return void
     */
    public function clear()
    {
        $this->getStorage()->clear();
    }

    /**
     * 
     */
    public function logout($id)
    {
        $this->getStorage()->clear();
    }

    public function session()
    {
        $session = new SessionContainer($this->getStorage()->getNameSpace());
        $session->getManager()->regenerateId();
        $storage = $this->getStorage()->read();
        return $storage;
    }

    public function login_data()
    {

        /*
          $session = new SessionContainer($this->getStorage()->getNameSpace());
          $session->getManager()->regenerateId();
          $storage = $this->getStorage()->read();
         */
        $storage = $this->session();
        $data = array();
        $data["lisPerson"] = $storage["lisPerson"];
        $data["lisUser"] = $storage["lisUser"];
        $data["role"] = $storage["role"];
        return $data;
    }

    /**
     * 
     * @param string $email
     * @param string $password
     * @param string $entityName
     * @param string $role
     */
    private function auth($email, $password, $entityName, $role)
    {
        $user = $this->getEntityManager()
                ->getRepository($entityName)
                ->FetchUser($email); //all good if no exceptions

        Hash::verifyHash($password, $user['lisUser']['password']); //all good if no exceptions
        /*
          $session = new SessionContainer($this->getStorage()->getNameSpace()); //regen the id
          $session->getManager()->regenerateId();

          $storage = $this->getStorage()->read(); //fill session with relevant data
         */
        $storage = $this->session();
        $storage['role'] = $role;
        $storage['lisPerson'] = $user['id'];
        $storage['lisUser'] = $user['lisUser']['id'];
        $this->getStorage()->write($storage);
    }

    public function loginCheck()
    {
        
    }

    /**
     * NB user can have many results
     * NB thin some way to deal brute force
     * 
     * @param array $data
     * @param string $role
     * @return array
     */
    public function authenticate($data, $role)
    {
        try {
            $this->logout(1); //logout first 

            $email = Validator::validateEmail($data['email']);
            $password = Validator::validatePassword($data['password']);
            if ($role === 'administrator') {
                $this->auth($email, $password, 'Core\Entity\Administrator', $role);
            } else if ($role === 'teacher') {
                $this->auth($email, $password, 'Core\Entity\Teacher', $role);
            } else if ($role === 'student') {
                $this->auth($email, $password, 'Core\Entity\Student', $role);
            } else {
                throw new Exception('NO_ROLE_SPECIFIED');
            }
            $data_login = $this->login_data();

            return [
                'success' => true,
                'message' => 'NOW_LOGGED_IN',
                "lisPerson" => $data_login["lisPerson"],
                "lisUser" => $data_login["lisUser"],
                "role" => $data_login["role"],
            ];
        } catch (Exception $ex) {

            return [

                'success' => false,
                'message' => 'FALSE_ATTEMPT'
            ];
        }
    }

}

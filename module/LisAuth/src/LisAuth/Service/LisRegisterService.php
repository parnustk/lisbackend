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
use Exception;
use LisAuth\Utility\Validator;
use Zend\Crypt\Password\Bcrypt;

/**
 * Description of LisRegisterService
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LisRegisterService implements ServiceManagerAwareInterface
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
     * Check if personalCode exists
     * 
     * @param array $data
     * @return string
     * @throws Exception
     */
    private function _validatePersonalCode($data)
    {
        if (!key_exists('personalCode', $data)) {
            throw new Exception('PERSONALCODE_MISSING');
        }
        if (!$data['personalCode']) {
            throw new Exception('PERSONALCODE_EMPTY');
        }
        return $data['personalCode'];
    }

    /**
     * 
     * @param type $entity
     * @return type
     * @throws Exception
     */
    private function _validateEntityAgainstUser($entity)
    {
        if (!$entity) {//does not exist
            throw new Exception('NOT_FOUND');
        }
        if ($entity->getLisUser()) {//already has a user
            throw new Exception('ALREADY_REGISTERED');
        }
        return $entity;
    }

    /**
     * 
     * @param type $personalCode
     * @param type $e
     * @return Core\Entity\Student|null
     */
    private function _getByPersonalCode($personalCode, $e)
    {
        return $this->getEntityManager()
                        ->getRepository($e)
                        ->findOneBy(['personalCode' => $personalCode]);
    }
    
    /**
     * Password Cost
     *
     * The number represents the base-2 logarithm of the iteration count used for
     * hashing. Default is 14 (about 10 hashes per second on an i5).
     *
     * Accepted values: integer between 4 and 31
     * @var type 
     */
    private $passwordCost = 4;
    
    /**
     * 
     * @param type $password
     * @return type
     * @throws Exception
     */
    public function passwordToHash($password)
    {
        if (empty($password)) {
            throw new Exception('NO_PASSWORD');
        }
        return (new Bcrypt)
                        ->setCost($this->passwordCost)
                        ->create($password);
    }

    /**
     * 
     * @param array $data
     * @param string $e
     * @return array
     */
    public function register($data, $e)
    {
        try {
            Validator::validatePassword($data['password']);
            $entity = $this->_validateEntityAgainstUser(
                    $this->_getByPersonalCode(
                            $this->_validatePersonalCode($data), $e
                    )
            );
            
            $lisUser = $this->getEntityManager()
                    ->getRepository('Core\Entity\LisUser')
                    ->findOneBy(['email' => $data['email']]);
            
            if (!$lisUser) {//user does not exist create one
                $lisUser = $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\LisUser')
                        ->Create($data);
            }
            
            $entity->setLisUser($lisUser)->setEmail($data['email']); //associate
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush($entity);
            
            return [
                'success' => true,
                'email' => $entity->getEmail(),
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Main entrance for regiter process
     * 
     * @param array $data
     * @param string $role
     * @return array
     */
    public function registerLisUser($data, $role)
    {
        $r = [];
        switch ($role) {
            case 'administrator':
                $r = $this->register($data, 'Core\Entity\Administrator');
                break;
            case 'teacher':
                $r = $this->register($data, 'Core\Entity\Teacher');
                break;
            case 'student':
                $r = $this->register($data, 'Core\Entity\Student');
                break;
            default:
                $r = [
                    'success' => false,
                    'message' => 'WRONG_ROLE',
                ];
                break;
        }
        return $r;
    }

}

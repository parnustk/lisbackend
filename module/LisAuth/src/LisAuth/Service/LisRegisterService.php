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

/**
 * Description of LisRegisterService
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LisRegisterService implements ServiceManagerAwareInterface
{

    /**
     * Key for crypting
     * TODO get it from config
     */
    const KEY = 'x3xuKEA5+Ec7cY:_';

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

        $personalCode = $data['personalCode'];

        if (!$data['personalCode']) {
            throw new Exception('PERSONALCODE_EMPTY');
        }

        return $personalCode;
    }

    private function _validateEntityAgainstUser($entity)
    {
        if (!$entity) {//does not exist
            throw new Exception('NOT_FOUND');
        }
     
        
        if ($entity->getLisUser()) {//already has a user
            throw new Exception('ALREADY_REGISTERED');
        }
    }

    /**
     * 
     * @param string $personalCode
     * @return Core\Entity\Student|null
     */
    private function _getStudentByPersonalCode($personalCode)
    {
        return $this->getEntityManager()
                        ->getRepository('Core\Entity\Student')
                        ->findOneBy(['personalCode' => $personalCode]);
    }

    /**
     * 
     * @param type $data
     * @return array
     */
    private function _registerStudent($data)
    {
        
        $student = $this->_getStudentByPersonalCode(
                $this->_validatePersonalCode($data)
        );

        $this->_validateEntityAgainstUser($student);

        //check if user exists if exists associate
        
        $lisUser = $this->getEntityManager()
                ->getRepository('Core\Entity\LisUser')
                ->findOneBy(['email' => $data['email']]);
        
        if (!$lisUser) {//user does not exist create one
            $lisUser = $this
                    ->getEntityManager()
                    ->getRepository('Core\Entity\LisUser')
                    ->Create($data);
        }
      
        $student->setLisUser($lisUser); //associate
        
        $this->getEntityManager()->persist($student);
        $this->getEntityManager()->flush($student);
        $this->getEntityManager()->clear();

        return [
            'success' => true
        ];
    }

    /**
     * Student can be registered if personalCode is found from Student
     * and if that student does not have user
     *  
     * @param array $data
     * @return array
     */
    public function registerStudent($data)
    {
        try {
            return $this->_registerStudent($data);
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

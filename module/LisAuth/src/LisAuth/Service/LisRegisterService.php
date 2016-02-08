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
 * @author sandev
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
     * 
     * @param type $personalCode
     */
    private function getStudentByPersonalCode($personalCode)
    {
        return $this->getEntityManager()
                        ->getRepository('Core\Entity\Student')
                        ->findBy(['personalCode' => $personalCode]);
    }

    private function _registerStudent($data)
    {
        if (!key_exists('personalCode', $data)) {
            throw new Exception('PERSONALCODE_MISSING');
        }

        $personalCode = $data['personalCode'];

        if (!$data['personalCode']) {
            throw new Exception('PERSONALCODE_EMPTY');
        }

        $s = $this->getStudentByPersonalCode($personalCode);

        if (!$s) {//does not exist
            throw new Exception('NOT_FOUND');
        }

        if (!!$s->getLisUser()) {//already has a user
            throw new Exception('ALREADY_REGISTERED');
        }
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
            $this->_registerStudent($data);
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

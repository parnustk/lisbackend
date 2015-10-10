<?php

namespace Core\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use Core\Entity\Sample;
use Exception;
use Zend\Json\Json;

/**
 * Teting Service set up. Remove later on.
 * @author sander
 */
class VocationService implements ServiceManagerAwareInterface
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
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     * @param ServiceManager $serviceManager
     * @return \Core\Service\Test
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
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
     * @param EntityManager $entityManager
     * @return \Core\Service\SampleService
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function GetList()
    {
        try {
            $r = $this->getEntityManager()
                    ->getRepository('Core\Entity\Sample')
                    ->GetList();
            return [
                'success' => false,
                'data' => $r
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
        
    }

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function Create($data)
    {
        try {
            $sample = $this->getEntityManager()
                    ->getRepository('Core\Entity\Sample')
                    ->Create($data);

            return [
                'success' => true,
                'data' => $sample->getArrayCopy()
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

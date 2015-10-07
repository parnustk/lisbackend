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
class SampleService implements ServiceManagerAwareInterface
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
    public function GetSamples()
    {
        $rep = $this->getEntityManager()->getRepository('Core\Entity\Sample');
        return $rep->QuerySamples();
    }

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function AddSample($data)
    {
        $sample = new Sample($this->getEntityManager());
        $sample->hydrate($data);
        if (!$sample->validate()) {
            throw new Exception(Json::encode($sample->getMessages(), true));
        }
        $this->getEntityManager()->persist($sample);
        $this->getEntityManager()->flush($sample);
        return true;
    }

}

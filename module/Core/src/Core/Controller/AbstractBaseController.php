<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

/**
 * @author sander
 */
abstract class AbstractBaseController extends AbstractRestfulController
{

    /**
     * Allow CORS
     * @return JsonModel
     */
    public function options()
    {
        return new JsonModel([]);
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}

<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Abstract Base controller
 * 
 * @author sander
 */
abstract class AbstractBaseController extends AbstractRestfulController
{

    /**
     *
     * @var stdClass 
     */
    protected $params;

    /**
     * Allow CORS
     * 
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

    /**
     * 
     * @return array
     */
    protected function GetParams()
    {
        $this->params = $this->params()->fromQuery();
        $this->params['page'] = $this->params()->fromQuery('page', 1);
        $this->params['limit'] = $this->params()->fromQuery('limit', 10000);
        return $this->params;
    }

}

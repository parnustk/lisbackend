<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use stdClass;
use Zend\View\Model\JsonModel;

/**
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
     * @return JsonModel
     */
    public function options()
    {
        return new JsonModel([]);
    }

    /**
     * 
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * 
     * @return type
     */
    protected function GetParams()
    {
        $this->params = new stdClass;
        $this->params->all = $this->params()->fromQuery();
        $this->params->page = $this->params()->fromQuery('page', 1);
        $this->params->limit = $this->params()->fromQuery('limit', 200);
        return $this->params;
    }

}

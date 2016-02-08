<?php
/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Exception;

/**
 * Abstract Base controller
 * 
 * @author Sander Mets <sandermets0@gmail.com>
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
        $where = $this->params()->fromQuery('where', null);

        try {//if somebody messes with json format and Zend/Json trhows exception
            $this->params['where'] = (!!$where) ? Json::decode($where) : null;
        } catch (Exception $ex) {
            $this->params['where'] = null;
        }

        return $this->params;
    }
    
    /**
     * GET
     *
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->GetList($this->GetParams())
        );
    }
    
    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->Get($id)
        );
    }
    
    /**
     * POST
     * 
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->Create($data)
        );
    }
    
    /**
     * PUT
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->Update($id, $data)
        );
    }
    
    /**
     * DELETE
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->Delete($id)
        );
    }
    
    /**
     * 
     * @return type
     */
    public function notAllowed()
    {
        $this->response->setStatusCode(405);

        return [
            'content' => 'Method Not Allowed'
        ];
    }

}

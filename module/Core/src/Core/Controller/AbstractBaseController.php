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
     * http://stackoverflow.com/questions/25727306/request-header-field-access-control-allow-headers-is-not-allowed-by-access-contr
     * https://developer.tizen.org/dev-guide/web/2.3.0/org.tizen.mobile.web.appprogramming/html/tutorials/w3c_tutorial/sec_tutorial/using_preflight_request.htm
     * Case for non Apache environment
     */
    public function headerAccessControlAllowOrigin()
    {
        if (key_exists('SERVER_SOFTWARE', $_SERVER)) {//check for phpunit env
            if (strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') === false) {
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Headers: Content-Type");
            }
        }
    }

    /**
     * Allow CORS
     * 
     * @return JsonModel
     */
    public function options()
    {
        $this->headerAccessControlAllowOrigin();
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
     * @return \LisAuth\Service\LisAuthService
     */
    public function getLisAuthService()
    {
        return $this->getServiceLocator()->get('lisauth_service');
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

<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuth\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController as Base;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LoginAdministratorController extends Base
{

    /**
     * 
     * @return LisAuth\Service\LisRegisterService
     */
    public function getLisAuthService()
    {
        return $this->getServiceLocator()->get('lisauth_service');
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
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel([]);
    }

    /**
     * Register new user Administrator
     * 
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        $this->headerAccessControlAllowOrigin();
        return new JsonModel(
                $this
                        ->getLisAuthService()
                        ->authenticate($data, 'administrator')
        );
    }

    /**
     * Update existing user Administrator
     * 
     * @param int $id
     * @param array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel([$id, $data]);
    }

    /**
     * Delete existing user Administrator
     * 
     * @param int $id
     * @return JsonModel
     */
    public function delete($id)
    {
        $this->headerAccessControlAllowOrigin();
        return new JsonModel($this
                        ->getLisAuthService()
                        ->logout($id));
    }

}

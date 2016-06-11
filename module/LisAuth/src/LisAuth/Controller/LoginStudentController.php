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
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class LoginStudentController extends Base
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
     * Register new user Student
     * 
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {
        $this->headerAccessControlAllowOrigin();
        $lisAuthService = $this->getLisAuthService();
        $r = [];
        try {
            $lisAuthService->authenticate($data, 'student');
            $data_login = $lisAuthService->login_data();
            if (!$lisAuthService->isEmpty()) {//check_logined
                if (method_exists($this->getResponse(), 'getCookie')) {
                    $cookie = $this->getResponse()->getCookie();
                    if ($cookie) {
                        if (property_exists($this->getResponse()->getCookie(), 'userObj')) {
                            $cuserObj = $this->getResponse()->getCookie()->userObj;
                            $id = $cuserObj;
                            if ($id !== $data_login["lisUser"]) {
                                $lisAuthService->logout(1);
                                throw new Exception('COOKIE_MISMATCH');
                            }
                        }
                    }
                }
            }
            if($data_login["role"] === 'student') {//get vocation id
                
                $em = $this->getEntityManager();
            }
            
            $r = [
                'success' => true,
                'message' => 'NOW_LOGGED_IN',
                "lisPerson" => $data_login["lisPerson"],
                "lisUser" => $data_login["lisUser"],
                "role" => $data_login["role"],
            ];
        } catch (Exception $ex) {
            $r = [
                'success' => false,
                'message' => $ex->getMessage()
                //'message' => 'FALSE_ATTEMPT'
            ];
        }
        return new JsonModel($r);
    }

    /**
     * Update existing user Student
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel([$id, $data]);
    }

    /**
     * Delete existing user Student
     * 
     * @param type $id
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

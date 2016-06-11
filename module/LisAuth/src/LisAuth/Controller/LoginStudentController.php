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
use Exception;

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
     * Register new user Student
     * 
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {
        $this->headerAccessControlAllowOrigin();
        $lisAuthService = $this->getLisAuthService();
        
        try {
            $lisAuthService->authenticate($data, 'student');
            $data_login = $lisAuthService->login_data();

            if (is_null($data_login["lisPerson"]) ||
                    is_null($data_login["lisPerson"]) ||
                    is_null($data_login["role"])) {

                $lisAuthService->logout();
                throw new Exception('LIS_33_NOT_LOGGED_IN');
            }

            return new JsonModel([
                'success' => true,
                'message' => 'LIS_NOW_LOGGED_IN',
                "lisPerson" => $data_login["lisPerson"],
                "lisUser" => $data_login["lisPerson"],
                "role" => $data_login["role"],
            ]);
        } catch (Exception $ex) {

            return new JsonModel([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
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

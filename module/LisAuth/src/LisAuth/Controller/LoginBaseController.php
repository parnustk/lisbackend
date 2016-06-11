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
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LoginBaseController extends Base
{

    protected function checkRole()
    {
        $this->GetParams();
        if (array_key_exists('ferole', $this->params)) {
            if ($this->params['ferole'] !== $this->role) {
                throw new Exception('LIS_42_NOT_LOGGED_IN');
            }
        } else {
            throw new Exception('LIS_41_NOT_LOGGED_IN');
        }
    }

    /**
     * Check for active session
     * 
     * @return JsonModel
     */
    public function getList()
    {
        try {
            $this->headerAccessControlAllowOrigin();
            if ($this->getLisAuthService()->isEmpty()) {
                throw new Exception('NOT_40_LOGGED_IN');
            }
            $this->checkRole();
            $data_login = $this->getLisAuthService()->login_data();
            if (is_null($data_login["lisPerson"]) ||
                    is_null($data_login["lisPerson"]) ||
                    is_null($data_login["role"])) {

                throw new Exception('LIS_33_NOT_LOGGED_IN');
            }
            
            if($this->params['ferole'] !== $data_login["role"]) {
                throw new Exception('LIS_35_NOT_LOGGED_IN');
            }

            $super = false;
            if ($this->role === 'administrator') {
                $admin = $this->getEntityManager()
                        ->find(
                        'Core\Entity\Administrator', $data_login["lisPerson"]
                );
                if ($admin) {
                    if ($admin->getSuperAdministrator() === 1) {
                        $super = true;
                    }
                }
            }

            return new JsonModel([
                'success' => true,
                'message' => 'LIS_ACTIVE_SESSION',
                "super" => $super,
                "lisPerson" => $data_login["lisPerson"],
                "lisUser" => $data_login["lisPerson"],
                "role" => $data_login["role"],
            ]);
        } catch (Exception $ex) {
            $this->getLisAuthService()->clear();
            return new JsonModel([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Login administrator
     * 
     * @param array $data
     * @return JsonModel
     * @throws Exception
     */
    public function create($data)
    {
        $this->headerAccessControlAllowOrigin();
        $lisAuthService = $this->getLisAuthService();

        try {
            $lisAuthService->authenticate($data, $this->role);
            $data_login = $lisAuthService->login_data();

            if (is_null($data_login["lisPerson"]) ||
                    is_null($data_login["lisPerson"]) ||
                    is_null($data_login["role"])) {

                $lisAuthService->logout();
                throw new Exception('LIS_33_NOT_LOGGED_IN');
            }

            $super = false;
            if ($this->role === 'administrator') {
                $admin = $this->getEntityManager()
                        ->find(
                        'Core\Entity\Administrator', $data_login["lisPerson"]
                );
                if ($admin->getSuperAdministrator() === 1) {
                    $super = true;
                }
            }

            return new JsonModel([
                'success' => true,
                'message' => 'LIS_NOW_LOGGED_IN',
                "super" => $super,
                "lisPerson" => $data_login["lisPerson"],
                "lisUser" => $data_login["lisPerson"],
                "role" => $data_login["role"],
            ]);
        } catch (Exception $ex) {
            sleep(1);
            $this->getLisAuthService()->clear();
            return new JsonModel([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
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

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
     * 
     * @param string $entityName
     * @param array $data_login
     * @return stdClass
     * @throws Exception
     */
    protected function additionalUserInfo($entityName, $data_login)
    {
        $userinfo = (object) [
                    'super' => false,
                    'firstName' => '',
                    'lastName' => '',
        ];
        $model = $this->getEntityManager()
                ->find(
                $entityName, $data_login["lisPerson"]
        );
        if ($model) {
            if ($entityName === 'Core\Entity\Administrator') {
                if ($model->getSuperAdministrator() === 1) {
                    $userinfo->super = true;
                }
            }
            $userinfo->firstName = $model->getFirstName();
            $userinfo->lastName = $model->getLastName();
        } else {
            throw new Exception('NOT_48_LOGGED_IN');
        }
        return $userinfo;
    }

    protected function sessionBasedChecks($data_login)
    {
        $entityName = '';
        if ($this->role === 'administrator') {
            $entityName = 'Core\Entity\Administrator';
        } else if ($this->role === 'student') {
            $entityName = 'Core\Entity\Student';
        } else if ($this->role === 'teacher') {
            $entityName = 'Core\Entity\Teacher';
        }
        $userinfo = $this->additionalUserInfo($entityName, $data_login);
        return [
            "super" => $userinfo->super,
            "firstName" => $userinfo->firstName,
            "lastName" => $userinfo->lastName,
            'success' => true,
            'message' => 'LIS_ACTIVE_SESSION',
            "lisPerson" => $data_login["lisPerson"],
            "lisUser" => $data_login["lisUser"],
            "role" => $data_login["role"],
        ];
    }

    /**
     * Check for active session
     * 
     * @return JsonModel
     */
    public function getList()
    {
        $this->headerAccessControlAllowOrigin();
        try {
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

            if ($this->params['ferole'] !== $data_login["role"]) {
                throw new Exception('LIS_35_NOT_LOGGED_IN');
            }
            
            return new JsonModel($this->sessionBasedChecks($data_login));
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
        try {
            $this->getLisAuthService()->authenticate($data, $this->role);
            $data_login = $this->getLisAuthService()->login_data();
            return new JsonModel($this->sessionBasedChecks($data_login));
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

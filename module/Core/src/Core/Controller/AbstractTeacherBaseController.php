<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Controller;

use Zend\View\Model\JsonModel;
use Core\Entity\Teacher;
use Core\Entity\LisUser;
use stdClass;
use Exception;
/**
 * Application ACL resolves by this layer
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
abstract class AbstractTeacherBaseController extends AbstractBaseController
{

    /**
     *
     * @var string
     */
    protected $lisRole = 'teacher';

    /**
     *
     * @var LisUser|null
     */
    protected $lisUser = null;

    /**
     *
     * @var Teacher|null
     */
    protected $lisPerson = null;

    /**
     * 
     * @return string
     */
    public function getLisRole()
    {
        return $this->lisRole;
    }

    /**
     * 
     * @return LisUser|null
     */
    public function getLisUser()
    {
        return $this->lisUser;
    }

    /**
     * 
     * @return Teacher
     */
    public function getLisPerson()
    {
        return $this->lisPerson;
    }

    /**
     * 
     * @param string $lisRole
     * @return \Core\Controller\AbstractStudentBaseController
     */
    public function setLisRole($lisRole)
    {
        $this->lisRole = $lisRole;
        return $this;
    }

    /**
     * 
     * @param LisUser $lisUser
     * @return \Core\Controller\AbstractStudentBaseController
     */
    public function setLisUser(LisUser $lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    /**
     * 
     * @param Teacher $lisPerson
     * @return \Core\Controller\AbstractStudentBaseController
     */
    public function setlisPerson(Teacher $lisPerson)
    {
        $this->lisPerson = $lisPerson;
        return $this;
    }

   /**
     * 
     */
    protected function checkUserSession()
    {
        $auth = $this->getLisAuthService();
        $storage = $auth->read();
//        print_r(gettype($storage));
        try {
            if (!$storage) {
                throw new Exception('1NOT_LOGGED_IN');
            }
            if (!key_exists('role', $storage)) {
                throw new Exception('2NOT_LOGGED_IN');
            }
            if ($storage['role'] !== $this->lisRole) {
                throw new Exception('3NOT_LOGGED_IN');
            }
            if (!key_exists('lisPerson', $storage)) {
                throw new Exception('4NOT_LOGGED_IN');
            }
            if (!key_exists('lisUser', $storage)) {
                throw new Exception('5NOT_LOGGED_IN');
            }

            $lisUser = $this->getEntityManager()->getRepository('Core\Entity\LisUser')->find($storage['lisUser']);
            if (!$lisUser instanceof \Core\Entity\LisUser) {
                throw new Exception('6NOT_LOGGED_IN');
            }
            $this->setLisUser($lisUser);

            $lisPerson = $this->getEntityManager()->getRepository('Core\Entity\Teacher')->find($storage['lisPerson']);
            if (!($lisPerson instanceof \Core\Entity\Teacher)) {
                throw new Exception('7NOT_LOGGED_IN');
            }
            $this->setlisPerson($lisPerson);

            return ['NOT_LOGGED_IN' => false];
        } catch (Exception $ex) {
            print_r($ex->getMessage());die;
            return ['NOT_LOGGED_IN' => true];
        }
    }

    /**
     * 
     * @return stdClass
     */
    protected function GetExtra()
    {
        if (!$this->lisUser || !$this->lisPerson) { //testing environment
            $this->checkUserSession();
        }

        $e = (object) [
                    'lisRole' => $this->getLisRole(),
                    'lisUser' => $this->getLisUser(),
                    'lisPerson' => $this->getLisPerson(),
        ];
        $this->headerAccessControlAllowOrigin();
        return $e;
    }

    /**
     * GET
     *
     * @return JsonModel
     */
    public function getList()
    {
        $params = $this->GetParams();
        $extra = $this->GetExtra();
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->GetList($params, $extra)
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
                        ->Get($id, $this->GetExtra())
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
                        ->Create($data, $this->GetExtra())
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
                        ->Update($id, $data, $this->GetExtra())
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
                        ->Delete($id, $this->GetExtra())
        );
    }

}

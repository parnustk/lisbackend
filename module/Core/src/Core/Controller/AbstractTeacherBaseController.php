<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Controller;

use Core\Entity\LisUser;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
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
     * @return \Core\Controller\AbstractTeacherBaseController
     */
    public function setLisRole($lisRole)
    {
        $this->lisRole = $lisRole;
        return $this;
    }

    /**
     * 
     * @param LisUser $lisUser
     * @return \Core\Controller\AbstractTeacherBaseController
     */
    public function setLisUser(\Core\Entity\LisUser $lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

    /**
     * 
     * @param \Core\Entity\Student $lisPerson
     * @return \Core\Controller\AbstractTeacherBaseController
     */
    public function setLisPerson(\Core\Entity\Teacher $lisPerson)
    {
        $this->lisPerson = $lisPerson;
        return $this;
    }

    /**
     * 
     * @return stdClass
     */
    protected function GetExtra()
    {
        return (object) [
                    'lisRole' => $this->getLisRole(),
                    'lisUser' => $this->getLisUser(),
                    'lisPerson' => $this->getLisPerson(),
        ];
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
                        ->GetList($this->GetParams(), $this->GetExtra())
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

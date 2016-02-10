<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace Core\Controller;

/**
 * Application ACL resolves by this layer
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
abstract class AbstractAdministratorBaseController extends AbstractBaseController
{

    /**
     *
     * @var string 
     */
    protected $lisRole = 'administrator';

    /**
     *
     * @var Core\Entity\LisUser|null
     */
    protected $lisUser = null;

    /**
     *
     * @var Core\Entity\LisUser|null
     */
    protected $lisUser = null;

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
     * @return Core\Entity\LisUser|null
     */
    public function getLisUser()
    {
        return $this->lisUser;
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
     * @param \Core\Controller\Core\Entity\LisUser $lisUser
     * @return \Core\Controller\AbstractStudentBaseController
     */
    public function setLisUser(Core\Entity\LisUser $lisUser)
    {
        $this->lisUser = $lisUser;
        return $this;
    }

}

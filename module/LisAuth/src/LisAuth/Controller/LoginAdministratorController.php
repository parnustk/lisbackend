<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuth\Controller;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LoginAdministratorController extends LoginBaseController
{

    protected $role = 'administrator';

    /**
     * 
     * @return type
     */
    public function getList()
    {
        return parent::getList();
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function create($data)
    {
        return parent::create($data);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function get($id)
    {
        return parent::notAllowed();
    }

    /**
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    public function update($id, $data)
    {
        return parent::notAllowed();
    }

}

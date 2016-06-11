<?php

/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */
namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractAdministratorBaseController as Base;

/**
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

class UserDataController extends Base
{
    protected $service = 'userdata_service';
    
    public function create($data)
    {
        return parent::notAllowed();
    }
    
    public function get($id)
    {
        return parent::get($id);
    }
    
    public function getList()
    {
        return parent::notAllowed();
    }
    
    public function update($id, $data)
    {
        return parent::update($id, $data);
    }
    
    public function delete($id)
    {
        return parent::notAllowed();
    }
}
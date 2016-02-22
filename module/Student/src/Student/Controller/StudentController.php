<?php

/**Licence of Learning Info System (LIS)
 * Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * 
 * You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */
namespace Student\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractStudentBaseController as Base;

/**
 * Restrictions for student role:
 * 
 * YES getList - OWN RELATED
 * YES get - OWN RELATED
 *
 * @author Marten Kähr
 */
class StudentController extends Base
{
    /**
     * <h2>GET student</h2>
     * <h3>URL Parameters</h3>
     * <code>limit(integer)
     * page(integer)</code>
     * 
     * @return JsonModel
     */
    public function getList()
    {
        
        
        if (true)
        {
            return parent::getList();
        }
        else 
        {
            return parent::notAllowed();
        }
    }
    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        
        
        if (true)
        {
            return parent::get($id);
        }
        else 
        {
            return parent::notAllowed();
        }
    }
    
    
    public function create($id) { return parent::notAllowed(); }
    public function update($id, $data) { return parent::notAllowed(); }
    public function delete($id) { return parent::notAllowed(); }
}

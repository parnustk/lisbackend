<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Entity\Repository;

/**
 *
 * @author sander
 */
interface CRUD
{

    /**
     * 
     * @param type $params
     * @param type $extra
     * @return Paginator
     */
    public function GetList($params = null, $extra = null);

    /**
     * 
     * @param type $id
     * @param type $returnPartial
     * @param \stdClass $extra
     */
    public function Get($id, $returnPartial = false, $extra = null);

    /**
     * 
     * @param type $data
     * @param type $returnPartial
     * @param \stdClass $extra
     */
    public function Create($data, $returnPartial = false, $extra = null);

    /**
     * 
     * @param type $id
     * @param type $data
     * @param type $returnPartial
     * @param \stdClass $extra
     */
    public function Update($id, $data, $returnPartial = false, $extra = null);

    /**
     * 
     * @param int $id
     * @param \stdClass $extra
     */
    public function Delete($id, $extra = null);
}

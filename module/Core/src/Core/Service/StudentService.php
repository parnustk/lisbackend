<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Service;

/**
 * Description of StudentService
 * @author Marten Kähr <marten@kahr.ee>
 */
class StudentService extends AbstractBaseService
{

    protected $baseEntity = 'Core\Entity\Student';

    /**
     * 
     * @param stdClass $params
     * @return array
     */
    public function GetList($params, $extra = null)
    {
        return parent::GetList($params, $extra);
    }

    /**
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return type
     */
    public function Get($params, $extra = null)
    {
        return parent::Get($params, $extra);
    }

    /**
     * 
     * @param array $data
     * @return array
     */
    public function Create($data, $extra = null)
    {
        return parent::Create($data, $extra);
    }

    /**
     * 
     * @param int|string $id
     * @param array $data
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Update($id, $data, $extra = null)
    {
        return parent::Update($id, $data, $extra);
    }

    /**
     * 
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Delete($id, $extra = null)
    {
        return parent::Delete($id, $extra);
    }

}

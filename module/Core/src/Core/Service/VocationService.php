<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Service;

use Exception;

/**
 * @author Juhan, Sander Mets <sandermets0@gmail.com>
 */
class VocationService extends AbstractBaseService
{

    /**
     * 
     * @param array $params
     * @param stdClass|NULL $extra
     * @return array
     */
    public function GetList($params, $extra = null)
    {
        try {

            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\Vocation')
                    ->GetList($params, $extra);

            $p->setItemCountPerPage($params['limit']);
            $p->setCurrentPageNumber($params['page']);
            
            
            $params['itemCount'] = $p->getTotalItemCount();
            $params['pageCount'] = $p->count();

            return [
                'success' => true,
                'params' => $params,
                'data' => (array) $p->getCurrentItems(),
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * 
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Get($id, $extra = null)
    {
        $Id = (int) $id;
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Vocation')
                        ->Get($Id, true, $extra)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * 
     * @param array $data
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Create($data, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Vocation')
                        ->Create($data, true, $extra)
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
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
        $Id = (int) $id;
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Vocation')
                        ->Update($Id, $data, true, $extra)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * 
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return array
     */
    public function Delete($id, $extra = null)
    {
        $Id = (int) $id;
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Vocation')
                        ->Delete($Id, $extra)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

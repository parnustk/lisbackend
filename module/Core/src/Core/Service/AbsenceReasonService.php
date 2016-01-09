<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace Core\Service;

use Exception;

/**
 * Rest API service for absencereason data.
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceReasonService extends AbstractBaseService
{

    /**
     * 
     * @param int $id
     * @return array
     */
    public function Get($id)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\AbsenceReason')
                        ->Get($id, true)
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
     * @param array $params
     * @return array
     */
    public function GetList($params)
    {
        try {

            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\AbsenceReason')
                    ->GetList($params);

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
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function Create($data)
    {

        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\AbsenceReason')
                        ->Create($data, true)
            ];
        } catch (Exception $ex) {

            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Update an existing resource
     *
     * @param  int $id
     * @param  mixed $data
     * @return array
     */
    public function Update($id, $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\AbsenceReason')
                        ->Update($id, $data, true)
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
     * @param int $id
     * @return array
     */
    public function Delete($id)
    {
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\AbsenceReason')
                        ->Delete($id)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

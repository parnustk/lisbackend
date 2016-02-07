<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core\Service;

use Exception;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 */
class SubjectRoundService extends AbstractBaseService
{

    /**
     * 
     * @param array $params
     * @param stdClass|null $extra
     * @return array
     */
    public function GetList($params, $extra = null)
    {
        try {
            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\SubjectRound')
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
     * @param int $id
     * @param stdClass|null $extra
     * @return array
     */
    public function Get($id, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\SubjectRound')
                        ->Get($id, true, $extra)
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
     * @param stdClass|null $extra
     * @return array
     */
    public function Create($data, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\SubjectRound')
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
     * @param int $id
     * @param array $data
     * @param stdClass|null $extra
     * @return array
     */
    public function Update($id, $data, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\SubjectRound')
                        ->Update($id, $data, true, $extra)
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
     * @param stdClass|null $extra
     * @return array
     */
    public function Delete($id, $extra = null)
    {
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\SubjectRound')
                        ->Delete($id, $extra)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }

}

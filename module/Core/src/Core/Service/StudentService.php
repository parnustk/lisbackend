<?php

namespace Core\Service;

use Exception;

/*
 * @author marten
 */

class StudentService extends \Core\Service\AbstractBaseService
{
    /**
     * 
     * @param stdClass $params
     * @return array
     */
    public function GetList($params, $extra = null)
    {
        try {

            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\Student')
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
     * @param int|string $id
     * @param stdClass|NULL $extra
     * @return type
     */
    public function Get($params, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Student')
                        ->Get($params, true)
            ];
        } catch (Exception $ex) {
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
            echo $ex->getMessage();
        }
    }
    /**
     * 
     * @param array $data
     * @return array
     */
    public function Create($data, $extra = null)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Student')
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
                        ->getRepository('Core\Entity\Student')
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
                        ->getRepository('Core\Entity\Student')
                        ->Delete($Id, $extra)
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
    public function Trash($id, $extra = null)
    {
        $Id = (int) $id;
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Student')
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
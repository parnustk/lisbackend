<?php

namespace Core\Service;

use Exception;

/**
 * Description of GradeChoiceService
 *
 * @author Arnold
 */
class GradeChoiceService extends AbstractBaseService
{
    /**
     * 
     * @param array $params
     * @return array
     */
    public function GetList($params)
    {
        try {
            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\GradeChoice')
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
     * @return type
     */
    public function Get($id)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\GradeChoice')
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
     * @param array $data
     * @throws Exception
     */
    public function Create($data)
    {
        //die("here service");
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\GradeChoice')
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
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function Update($id, $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\GradeChoice')
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
     * @param type $id
     * @return type
     */
    public function Delete($id)
    {
        try {
            return [
                'success' => true,
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\GradeChoice')
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
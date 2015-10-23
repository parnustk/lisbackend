<?php

namespace Core\Service;

use Exception;

/**
 * @author sander
 */
class SubjectService extends AbstractBaseService
{

    /**
     * 
     * @return type
     */
    public function GetList($params)
    {
        try {
            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\Subject')
                    ->GetList($params);
            
            $p->setItemCountPerPage($params->limit);
            $p->setCurrentPageNumber($params->page);

            return [
                'success' => true,
                'currentPage' => $params->page,
                'itemCount' => $p->getTotalItemCount(),
                'countPages' => $p->count(),
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
                        ->getRepository('Core\Entity\Subject')
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
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\Subject')
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
                        ->getRepository('Core\Entity\Subject')
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
     * @return type
     */
    public function Delete($id)
    {
        try {
            return [
                'success' => true,
                'id' => $this->getEntityManager()
                        ->getRepository('Core\Entity\Subject')
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

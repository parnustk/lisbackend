<?php

namespace Core\Service;

use Exception;

/**
 * @author sander
 */
class GradingTypeService extends AbstractBaseService
{

    /**
     * 
     * @param stdClass $params
     * @return array
     */
    public function GetList($params)
    {
        try {
            $p = $this->getEntityManager()
                    ->getRepository('Core\Entity\GradingType')
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
                'data' => $this->getEntityManager()
                        ->getRepository('Core\Entity\GradingType')
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
    public function Create(array $data)
    {
        try {
            return [
                'success' => true,
                'data' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\GradingType')
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
            $sample = $this->getEntityManager()
                    ->getRepository('Core\Entity\GradingType')
                    ->Update($id, $data);

            return [
                'success' => true,
                'data' => $sample->getArrayCopy()
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
                'id' => $this
                        ->getEntityManager()
                        ->getRepository('Core\Entity\GradingType')
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

<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Description of AbsenceReasonController
 *
 * @author eleri
 */
class AbsenceReasonController extends AbstractBaseController
{

    /**
     * GET
     * 
     * @return JsonModel
     */
    public function getList()
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->GetList($this->getParams())
        );
    }

    /**
     * GET
     * 
     * @param type $id
     * @return JsonModel
     */
    public function get($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->get($id)
        );
    }

    /**
     * POST
     * 
     * method to create new entity
     * @param type $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->Create($data)
        );
//        $s = $this->getServiceLocator()->get('absencereason_service');
//        $result = $s->Create($data);
//        return new JsonModel($result);
//        // return new JsonModel($data);
    }

    /**
     * PUT
     * 
     * @param type $id
     * @param type $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->Update($id, $data)
        );
    }

    /**
     * DELETE
     * 
     * @param type $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel(
                $this
                        ->getServiceLocator()
                        ->get('absencereason_service')
                        ->Delete($id)
        );
    }

}

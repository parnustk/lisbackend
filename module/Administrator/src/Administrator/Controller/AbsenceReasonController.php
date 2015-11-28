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
     * 
     * @param type $data
     */
    public function create($data)
    {

        $s = $this->getServiceLocator()->get('absencereason_service');
        $result = $s->Create($data);
        return new JsonModel($result);
        // return new JsonModel($data);
    }

}

<?php

namespace Administrator\Controller;

use Zend\View\Model\JsonModel;
use Core\Controller\AbstractBaseController;

/**
 * Description of GradeChoice
 *
 * @author Arnold
 */
class GradeChoiceController extends AbstractBaseController {

    public function create($data) {

        $s = $this->getServiceLocator()->get('gradechoice_service');
        $result=$s->Create($data);
        return new JsonModel($result);
    
    }
}

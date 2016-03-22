<?php

namespace BackupDB\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DumpController extends AbstractActionController
{
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }


    /**
     * Create new dump and return to client
     * 
     * @return ViewModel
     */
    public function createManualDump()
    {
        return new ViewModel();
    }

    /**
     * List filenames of dumps on server for front-end display
     * 
     * @param type $filter
     */
    public function getDumpList($filter = null) 
    {
        //TODO
    }
    
    /**
     * Push server dump named $dumpName to DB, or push raw $dumpData to DB
     * 
     * @param type $dumpName
     * @param type $dumpData
     */
    public function pushDump($dumpName, $dumpData = null)
    {
        //TODO
    }

}

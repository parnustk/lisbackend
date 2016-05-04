<?php

namespace BackupDB\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DumpController extends AbstractActionController
{

    /**
     * @var string
     */
    protected $service = 'dump_service';

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * Initial Display; List filenames of dumps on server for front-end display
     * Set up XDebug
     * @param type $filter
     */
    public function indexAction()
    {
        $this->pushAction("LISBACKUP_manual_29042016_121200", true);
        die('ENDPOINT');//we cut framework from here
//        return new ViewModel([
//            'content' => 'Backup Index Placeholder'
//        ]);
    }

    /**
     * Create new dump and return to client
     * 
     * @return ViewModel
     */
    public function createManualAction()
    {
        $this
                ->getServiceLocator()
                ->get($this->service)
                ->createDump('manual');
    }

    /**
     * Push server dump named $dumpName to DB, or push raw $dumpData to DB
     * 
     * @param string $filename
     * @param boolean $clearTable
     */
     
    public function pushAction($filename, $clearTable)
    {
        $this
                ->getServiceLocator()
                ->get($this->service)
                ->pushDump($filename, $clearTable);
//        return new ViewModel([
//            'content' => 'Push Backup Placeholder'
//        ]);
    }
    
    public function testAction()
    {
        $data = 'kontrollerist';
        return new ViewModel(['something' => $data]);
    }

}

<?php

namespace BackupDB\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;
use BackupDB\Form\loginForm;
use BackupDB\Form\panelForm;

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
     * Changes the layout to layout/backupdb
     * @param EventManagerInterface $events
     */
    public function setEventManager(EventManagerInterface $events)
    {
        //Zend_Layout::getMvcInstance()->setLayout(__DIR__ . '/../view/layout/application.phtml');
        parent::setEventManager($events);
        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            $controller -> layout('layout/backupdb');
        }, 100);
    }

    /**
     * Initial Display; List filenames of dumps on server for front-end display
     * Set up XDebug
     * @param type $filter
     */
    public function indexAction()
    {
        $this->createManualAction();
        die('ENDPOINT'); //we cut framework from here
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

    public function loginAction()
    {//usr psq from config
        //zend form
        //if credentials ok, put to session and redirect to panel
        $form = new loginForm('loginForm');
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            echo '<pre>';
            print_r($request->getPost());
            die('HERE');
            //check form fields against credentials in config file
            
            //if  valid save to session redirect to panel
        }
        //return array('form' => $form);

        return new ViewModel(['form' => $form]);
    }

    public function panelAction()//control panel
    {
        //check session if credentials not ok redirect to login
        //if credentials ok show panel form / file upload field, upload button, download button, serverside restore button, serverside back, logout button
        $data = 'panel';
        return new ViewModel(['something' => $data]);
    }

}

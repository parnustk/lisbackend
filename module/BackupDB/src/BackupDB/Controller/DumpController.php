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
     * @var type 
     */
    protected $client;

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
            $controller->layout('layout/backupdb');
        }, 100);
    }

    /**
     * Initial Display; List filenames of dumps on server for front-end display
     * Set up XDebug
     * @param type $filter
     */
    public function indexAction()
    {
        $this->loginAction();
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
            //check form fields against credentials in config file
            $data = include 'config/autoload/backupdb.local.php';
            $inputname = $request->getPost('username');
            $inputpwd = $request->getPost('password');
            $uname = $data['backupdb']['login']['loginuser'];
            $pwd = $data['backupdb']['login']['loginpwd'];
//            if ($inputname == $uname && $inputpwd == $pwd) {
            if (true) { //for panel testing
                //TODO: Session initialization
                return $this->redirect()->toUrl("//lis.local/backupdb/dump/panel");
            } else {
                return $this->redirect()->toUrl("//lis.local/backupdb/dump/login");
            }

            //if  valid save to session redirect to panel
        }
        //return array('form' => $form);

        return new ViewModel(['form' => $form]);
    }

    public function panelAction()//control panel
    {


        //check session if credentials not ok redirect to login
        $data = include 'config/autoload/backupdb.local.php';
        if (true) { //TODO: session check for credentials
            $request = $this->getRequest();
            if ($request->isPost()) {
                $postValues = $request->getPost();
                if (array_key_exists('uploadsubmit', $postValues)) {
                    //upload
                    die('upload');

                    //set no view render
                } else if (array_key_exists('downloadsubmit', $postValues)) {
                    //download
                    die('download');
                }
                $i = 0;
            } else {
                $panel = new panelForm('panelForm');
                $options = $this
                    ->getServiceLocator()
                    ->get($this->service)
                    ->getFilenames();
                $panel->get('fileselect')->setOptions($options);
                return new ViewModel(['form' => $panel]);
                
            }
        } else {//if credentials not ok, return to login
            die('COOKIE FAIL');
            $login = 'login';
            return new ViewModel(['form' => $login]);
        }
    }

    /**
     * Passes download request to Service
     * @param string $filename
     */
    public function downloadAction($filename)
    {
        $this
                ->getServiceLocator()
                ->get($this->service)
                ->download($filename);
    }

    /**
     * Passes upload request to Service
     * @param string $file
     */
    public function uploadAction($file)
    {
        $this
                ->getServiceLocator()
                ->get($this->service)
                ->upload($file);
    }

}

<?php

namespace BackupDB\Controller;

use Zend\Http\PhpEnvironment\Request;
use Zend\Filter\File\RenameUpload;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;
use Zend\Form\Element\Select;
use Zend\File\Transfer;
use BackupDB\Form\loginForm;
use BackupDB\Form\panelForm;
use Zend\Authentication\Storage;
use Zend\Session\Container as SessionContainer;

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
     * Redirect to login action
     * 
     */
    public function indexAction()
    {
        return $this->redirect()->toUrl("//lis.local/backupdb/dump/login");
    }

    /**
     * Display login view
     * 
     * @return ViewModel
     */
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
            if ($inputname == $uname && $inputpwd == $pwd) {
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
            if ($request->isPost()) { //Logic for panel reload after submit
                $postValues = $request->getPost();
                if (array_key_exists('uploadsubmit', $postValues)) { //Upload
                    $files = $request->getFiles();
                    $filename = 'data/BackupDB_Dumps/LISBACKUP_upload_' . 
                        date('dmY') . '_' . date('His');
                    $filter = new \Zend\Filter\File\RenameUpload($filename);
                    var_dump($filter->filter($files['fileupload']));
                    return $this->redirect()->toUrl("//lis.local/backupdb/dump/panel");
                    
                } else if (array_key_exists('downloadsubmit', $postValues)) { //Download
                    $list = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->getFilenames();
                    $fileName = $list[$postValues['fileselect']];
                    $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->download($fileName);
                    return $this->redirect()->toUrl("//lis.local/backupdb/dump/panel");
                } else if (array_key_exists('pushsubmit', $postValues)) { //Push
                    if ($postValues['pushcheckbox'] == 1) {
                        $list = $this
                                ->getServiceLocator()
                                ->get($this->service)
                                ->getFilenames();
                        $fileName = $list[$postValues['fileselect']];
                        $this
                                ->getServiceLocator()
                                ->get($this->service)
                                ->pushDump($fileName, null);
                        return $this->redirect()->toUrl("//lis.local/backupdb/dump/panel");
                    } else {
                        return $this->redirect()->toUrl("//lis.local/backupdb/dump/panel");
                    }
                } else {
                    return $this->redirect()->toUrl("//lis.local/backupdb/dump/login");
                }
            } else { //logic for first-time use
                $panel = new panelForm('panelForm');
                $filenames = $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->getFilenames();
                $element = $panel->get('fileselect');
                $element->setAttribute('options', $filenames);
                $element = $panel->get('pushselect');
                $element->setAttribute('options', $filenames);

                return new ViewModel(['form' => $panel]);
            }
        } else {//if credentials not ok, return to login
            die('COOKIE FAIL');
            $login = 'login';
            return new ViewModel(['form' => $login]);
        }
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

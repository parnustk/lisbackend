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
     * Display login view
     * 
     * @return ViewModel
     */
    public function loginAction()
    {//usr psq from config
        //zend form
        //if credentials ok, put to session and redirect to panel
        $form = new loginForm('loginForm');
        $form->get('submit')->setValue('Log In');

        $request = $this->getRequest();
        if ($request->isPost()) {
            //check form fields against credentials in config file
            $data = include 'config/autoload/backupdb.local.php';
            $inputname = $request->getPost('username');
            $inputpwd = $request->getPost('password');
            $uname = $data['backupdb']['login']['user'];
            $pwd = $data['backupdb']['login']['pwd'];
            $this
                    ->getServiceLocator()
                    ->get($this->service)
                    ->write(array(
                        'user' => $inputname,
                        'pwd' => $inputpwd
            ));
            return $this->redirect()->toUrl("//" . $data['backupdb']['login']['domain'] . "/backupdb/dump/panel");
        }

        return new ViewModel(['form' => $form]);
    }

    public function panelAction()//control panel
    {
        $data = include 'config/autoload/backupdb.local.php';
        //check session if credentials not ok redirect to login
        $session = $this
                ->getServiceLocator()
                ->get($this->service)
                ->read();
        if ($session['user'] == $data['backupdb']['login']['user'] &&
                $session['pwd'] == $data['backupdb']['login']['pwd']) { //If credentials match, proceed to panel
            $request = $this->getRequest();
            if ($request->isPost()) { //Logic for panel reload after submit
                $postValues = $request->getPost();
                if (array_key_exists('createsubmit', $postValues)) { //Create new backup on server
                    $list = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->createDump();
                    echo('CREATE SUCCESS<br>');
                    echo('<a href="http://' . $data['backupdb']['login']['domain'] .
                    '/backupdb/dump/login">Return to Panel</a>');
                    die();
                } else if (array_key_exists('uploadsubmit', $postValues)) { //Upload
                    $files = $request->getFiles();
                    $filename = 'data/BackupDB_Dumps/LISBACKUP_upload_' .
                            date('dmY') . '_' . date('His');
                    $filter = new \Zend\Filter\File\RenameUpload($filename);
                    var_dump($filter->filter($files['fileupload']));
                    echo('UPLOAD SUCCESS<br>');
                    echo('<a href="http://' . $data['backupdb']['login']['domain'] .
                    '/backupdb/dump/login">Return to Panel</a>');
                    die();
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
                    echo('DOWNLOAD SUCCESS<br>');
                    echo('<a href="http://' . $data['backupdb']['login']['domain'] .
                    '/backupdb/dump/login">Return to Panel</a>');
                    die();
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
                        echo('PUSH SUCCESS<br>');
                        echo('<a href="http://' . $data['backupdb']['login']['domain'] .
                        '/backupdb/dump/login">Return to Panel</a>');
                        die();
                    } else {
                        echo('PUSH FAIL; Not Confirmed<br>');
                        echo('<a href="http://' . $data['backupdb']['login']['domain'] .
                        '/backupdb/dump/login">Return to Panel</a>');
                        die();
                    }
                } else if (array_key_exists('logoutsubmit', $postValues)) { //Logout
                    $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->logout();
                    return $this->redirect()->toUrl("//" . $data['backupdb']['login']['domain'] . "/backupdb/dump/login");
                } else {
                    $panel = new panelForm('panelForm');
                    $filenames = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->getFilenames();
                    if ($filenames == null) {
                        $filenames = array();
                    }
                    $element = $panel->get('fileselect');
                    $element->setAttribute('options', $filenames);

                    return new ViewModel(['form' => $panel]);
                }
            } else { //logic for first-time use
                $panel = new panelForm('panelForm');
                $filenames = $this
                        ->getServiceLocator()
                        ->get($this->service)
                        ->getFilenames();
                if ($filenames == null) {
                    $filenames = array();
                }

                $element = $panel->get('fileselect');
                $element->setAttribute('options', $filenames);

                return new ViewModel(['form' => $panel]);
            }
        } else {//if credentials not ok, return to login
            echo('LOGIN FAIL<br>');
            echo('<a href="http://' . $data['backupdb']['login']['domain'] .
            '/backupdb/dump/login">Return to Login</a>');
            die();
        }
    }

}

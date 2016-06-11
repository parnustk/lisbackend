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
use Zend\Uri\UriFactory;

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
    {
        $form = new loginForm('loginForm');
        $form->get('submit')->setValue('Log In');

        $data = include 'config/autoload/backupdb.local.php';

        $request = $this->getRequest();
        if ($request->isPost()) {
            //check form fields against credentials in config file
            $inputname = $request->getPost('username');
            $inputpwd = $request->getPost('password');
            $this
                    ->getServiceLocator()
                    ->get($this->service)
                    ->write(array(
                        'user' => $inputname,
                        'pwd' => $inputpwd
            ));
            return $this->redirect()
                            ->toUrl($data['backupdb']['login']['protocol'] . '://' .
                                    $data['backupdb']['login']['domain'] .
                                    '/backupdb/dump/panel');
        }

        return new ViewModel(['form' => $form]);
    }

    public function panelAction()//control panel
    {
        $showForm = false;
        $viewMessage = '';
        $panel = null;
        $actionSuccess = false;
        $actionFail = false;
        $actionException = null;
        $actionType = null;

        $data = include 'config/autoload/backupdb.local.php';
        //check session if credentials not ok redirect to login
        $session = $this
                ->getServiceLocator()
                ->get($this->service)
                ->read();

        if ($session['user'] == $data['backupdb']['login']['user'] &&
                $session['pwd'] == $data['backupdb']['login']['pwd']) { //If credentials match, proceed to panel
            $request = $this->getRequest();

            if ($request->isPost()) { //no form
                $postValues = $request->getPost();

                if (array_key_exists('createsubmit', $postValues)) { //Create new backup on server
                    $actionType = 'Create';
                    $list = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->createDump();
                    if ($list['error']) {
                        
                    } else {
                        $actionSuccess = true;
                        $viewMessage = '<a class="btn btn-success" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                '/backupdb/dump/panel">Return to Panel</a>';
                    }
                } else if (array_key_exists('uploadsubmit', $postValues)) { //Upload
                    $actionType = 'Upload';
                    $files = $request->getFiles();
                    $upload = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->upload($files['fileupload']);
                    if ($upload['error']) {
                        $actionFail = true;
                        $actionException = $upload['exception'];
                        $viewMessage = '<a class="btn btn-danger" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                '/backupdb/dump/panel">Return to Panel</a>';
                    } else {
                        $actionSuccess = true;
                        $viewMessage = '<a class="btn btn-success" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                '/backupdb/dump/panel">Return to Panel</a>';
                    }
                } else if (array_key_exists('downloadsubmit', $postValues)) { //Download
                    $actionType = 'Download';
                    $list = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->getFilenames();
                    $fileName = $list[$postValues['fileselect']];
                    $download = $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->download($fileName);
                    if ($download['error']) {
                        $actionFail = true;
                        $actionType = 'Download';
                        $actionException = $download['exception'];
                    } else {
                        $actionSuccess = true;
                        $viewMessage = '<a class="btn btn-success" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                '/backupdb/dump/panel">Return to Panel</a>';
                    }
                } else if (array_key_exists('pushsubmit', $postValues)) { //Push
                    $actionType = 'Push';
                    if ($postValues['pushcheckbox'] == 1) {
                        $list = $this
                                ->getServiceLocator()
                                ->get($this->service)
                                ->getFilenames();
                        $fileName = $list[$postValues['fileselect']];
                        $push = $this
                                ->getServiceLocator()
                                ->get($this->service)
                                ->pushDump($fileName, null);
                        if ($push['error']) {
                            $actionFail = true;
                            $actionException = $push['exception'];
                            $viewMessage = '<a class="btn btn-danger" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                    '/backupdb/dump/panel">Return to Panel</a>';
                        }
                        $actionSuccess = true;
                        $viewMessage = '<a class="btn btn-success" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                '/backupdb/dump/panel">Return to Panel</a>';
                    } else {
                        $actionFail = true;
                        $actionException = 'You must check the box to confirm push to DB';
                        $viewMessage = '<a class="btn btn-danger" href="' . $data['backupdb']['login']['protocol'] . '://' . $data['backupdb']['login']['domain'] .
                                '/backupdb/dump/panel">Return to Panel</a>';
                    }
                } else if (array_key_exists('logoutsubmit', $postValues)) { //Logout REDIRECTS
                    $this
                            ->getServiceLocator()
                            ->get($this->service)
                            ->logout();
                    return $this->redirect()->toUrl("//" . $data['backupdb']['login']['domain'] . "/backupdb/dump/login");
                } else {//shows form
                    $showForm = true;
                    $panel = $this->createForm();
                }

                return new ViewModel([
                    'loginReturn' => false,
                    'actionSuccess' => $actionSuccess,
                    'actionFail' => $actionFail,
                    'actionType' => $actionType,
                    'actionException' => $actionException,
                    'showPanelForm' => $showForm,
                    'message' => $viewMessage,
                    'form' => $panel
                ]);
            } else { //show form
                $showForm = true;
                $panel = $this->createForm();
                return new ViewModel([
                    'loginReturn' => false,
                    'actionSuccess' => $actionSuccess,
                    'actionFail' => $actionFail,
                    'actionType' => $actionType,
                    'actionException' => $actionException,
                    'showPanelForm' => $showForm,
                    'message' => $viewMessage,
                    'form' => $panel
                ]);
            }
        } else {//if credentials not ok, return to login
            $viewMessage = '<a href="' . $data['backupdb']['login']['protocol'] . 
                    '://' . $data['backupdb']['login']['domain'] .
                    '/backupdb/dump/login">Return to Login</a>';
            return new ViewModel([
                    'loginReturn' => true,
                    'actionSuccess' => $actionSuccess,
                    'actionFail' => $actionFail,
                    'actionType' => $actionType,
                    'actionException' => $actionException,
                    'showPanelForm' => $showForm,
                    'message' => $viewMessage,
                    'form' => $panel
                ]);
        }
    }

    private function createForm()
    {
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
        return $panel;
    }

}

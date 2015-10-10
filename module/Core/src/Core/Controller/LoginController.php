<?php

namespace Core\Controller;

use Zend\View\Model\JsonModel;
use Exception;
use Zend\Json\Json;
use Core\Controller\AbstractBaseController;
use Zend\Form\Form;

/**
 * @author sander
 */
class LoginController extends AbstractBaseController
{

    /**
     * OPTIONS
     * headers are sent from .htaccess
     * 
     * @return type
     */
    public function options()
    {
        return new JsonModel([]);
    }

    /**
     * @var Form
     */
    protected $loginForm;

    public function getLoginForm()
    {
        if (!$this->loginForm) {
            $this->setLoginForm($this->getServiceLocator()->get('zfcuser_login_form'));
        }
        return $this->loginForm;
    }

    public function setLoginForm(Form $loginForm)
    {
        $this->loginForm = $loginForm;
        $fm = $this->flashMessenger()->setNamespace('zfcuser-login-form')->getMessages();
        if (isset($fm[0])) {
            $this->loginForm->setMessages(
                    array('identity' => array($fm[0]))
            );
        }
        return $this;
    }

    /**
     * LOGIN
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        try {
            if ($this->zfcUserAuthentication()->hasIdentity()) {//does not work
                return new JsonModel([
                    'success' => true,
                    'message' => 'Already logged in.'
                ]);
            }
            $form = $this->getLoginForm();

            $form->setData($data);
            $form->isValid();

            if (!$form->isValid()) {
                throw new Exception('INVALID LOGIN');
            }

            return new JsonModel([
                'success' => true,
                'message' => rand(1, 123456)
            ]);
        } catch (\Exception $exc) {
            return new JsonModel([
                'success' => false,
                'message' => $exc->getMessage()
            ]);
        }
    }

    /**
     * Logout
     * @return JsonModel
     */
    public function delete($id)
    {
        try {
            $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
            $this->zfcUserAuthentication()->getAuthAdapter()->logoutAdapters();
            $this->zfcUserAuthentication()->getAuthService()->clearIdentity();
            return new JsonModel([
                'success' => true,
                'message' => 'Have a nice day!'
            ]);
        } catch (\Exception $exc) {
            return new JsonModel([
                'success' => false,
                'message' => $exc->getMessage()
            ]);
        }
    }

    /**
     * Return list of resources
     *
     * @return mixed
     */
    public function getList()
    {
        try {
            $sampleService = $this
                    ->getServiceLocator()
                    ->get('sample_service');

            $r = $sampleService->GetSamples();

            return new JsonModel([
                'success' => true,
                'data' => $r
            ]);
        } catch (\Exception $exc) {
            return new JsonModel([
                'success' => false,
                'message' => $exc->getMessage()
            ]);
        }
    }

//    NOT TESTED YET
//    /**
//     * Return single resource
//     *
//     * @param  mixed $id
//     * @return mixed
//     */
//    public function get($id)
//    {
//        try {
//            $em = $this
//                    ->getServiceLocator()
//                    ->get('Doctrine\ORM\EntityManager');
//
//            $sample = new \Core\Entity\Sample($em);
//
//            $sample->setName('tere maailm');
//
//            if (!$sample->validate()) {
//                throw new Exception(\Zend\Json\Json::encode($sample->getMessages(), true));
//            }
//            return new JsonModel([
//                'success' => true,
//                'data' => []
//            ]);
//        } catch (\Exception $exc) {
//            return new JsonModel([
//                'success' => false,
//                'message' => $exc->getMessage()
//            ]);
//        }
//
//        return new JsonModel([$id]);
//    }
//
//    /**
//     * Update an existing resource
//     *
//     * @param  mixed $id
//     * @param  mixed $data
//     * @return mixed
//     */
    public function update($id, $data)
    {
        return new JsonModel([$id => $data]);
    }

//
//    /**
//     * Delete an existing resource
//     *
//     * @param  mixed $id
//     * @return mixed
//     */
//    public function delete($id)
//    {
//        return new JsonModel([$id]);
//    }
}

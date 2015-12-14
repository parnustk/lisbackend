<?php

namespace Core;

use ZfcUser\Controller\Plugin\ZfcUserAuthentication;
use Core\Service\VocationService;
use Core\Service\ModuleTypeService;
use Core\Service\GradingTypeService;
use Core\Service\ModuleService;
use Core\Service\SubjectService;
use Core\Service\AbsenceReasonService;
use Core\Service\StudentService;
use Core\Service\GroupService;
use Core\Service\TeacherService;
use Core\Service\GradeChoiceService;
use Core\Service\SubjectRoundService;

/**
 * 
 */
class Module
{

    /**
     * 
     * @return type
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * 
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'vocation_service' => function ($serviceManager) {
                    $t = new VocationService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'moduletype_service' => function ($serviceManager) {
                    $t = new ModuleTypeService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'gradingtype_service' => function ($serviceManager) {
                    $t = new GradingTypeService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'module_service' => function ($serviceManager) {
                    $t = new ModuleService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'subject_service' => function ($serviceManager) {
                    $t = new SubjectService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'absencereason_service' => function ($serviceManager) {
                    $t = new AbsenceReasonService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'student_service' => function ($serviceManager) {
                    $t = new StudentService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'group_service' => function ($serviceManager) {
                    $t = new GroupService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'teacher_service' => function ($serviceManager) {
                    $t = new TeacherService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'gradechoice_service' => function ($serviceManager) {
                    $t = new GradeChoiceService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'subjectround_service' => function ($serviceManager) {
                    $t = new SubjectRoundService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
            ],
        ];
    }

    /**
     * 
     * @return ZfcUserAuthentication
     */
    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'zfcUserAuthentication' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $authService = $serviceLocator->get('zfcuser_auth_service');
                    $authAdapter = $serviceLocator->get('ZfcUser\Authentication\Adapter\AdapterChain');
                    $controllerPlugin = new ZfcUserAuthentication;
                    $controllerPlugin->setAuthService($authService);
                    $controllerPlugin->setAuthAdapter($authAdapter);
                    return $controllerPlugin;
                },
            ),
        );
    }

}

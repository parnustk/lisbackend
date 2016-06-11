<?php
/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace Core;

use ZfcUser\Controller\Plugin\ZfcUserAuthentication;
use Core\Service\VocationService;
use Core\Service\ModuleTypeService;
use Core\Service\GradingTypeService;
use Core\Service\ModuleService;
use Core\Service\SubjectService;
use Core\Service\AbsenceReasonService;
use Core\Service\StudentService;
use Core\Service\StudentGroupService;
use Core\Service\TeacherService;
use Core\Service\GradeChoiceService;
use Core\Service\SubjectRoundService;
use Core\Service\RoomService;
use Core\Service\ContactLessonService;
use Core\Service\AdministratorService;
use Core\Service\AbsenceService;
use Core\Service\IndependentWorkService;
use Core\Service\StudentGradeService;
use Core\Service\StudentInGroupsService;
use Core\Service\SuperAdminService;
use Core\Service\UserDataService;

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
                'studentgroup_service' => function ($serviceManager) {
                    $t = new StudentGroupService();
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
                'room_service' => function ($serviceManager) {
                    $t = new RoomService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'contactlesson_service' => function ($serviceManager) {
                    $t = new ContactLessonService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'administrator_service' => function ($serviceManager) {
                    $t = new AdministratorService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'absence_service' => function ($serviceManager) {
                    $t = new AbsenceService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'independentwork_service' => function ($serviceManager) {
                    $t = new IndependentWorkService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'studentgrade_service' => function ($serviceManager) {
                    $t = new StudentGradeService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'studentingroups_service' => function ($serviceManager) {
                    $t = new StudentInGroupsService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'superadmin_service' => function ($serviceManager) {
                    $t = new SuperAdminService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'userdata_service' => function ($serviceManager) {
                    $t = new UserDataService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
            ],
        ];
    }

    /**
     * 
     * @return array
     */
    public function getControllerPluginConfig()
    {
        return [
            'factories' => [
                'zfcUserAuthentication' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $authService = $serviceLocator->get('zfcuser_auth_service');
                    $authAdapter = $serviceLocator->get('ZfcUser\Authentication\Adapter\AdapterChain');
                    $controllerPlugin = new ZfcUserAuthentication;
                    $controllerPlugin->setAuthService($authService);
                    $controllerPlugin->setAuthAdapter($authAdapter);
                    return $controllerPlugin;
                },
            ],
        ];
    }

}

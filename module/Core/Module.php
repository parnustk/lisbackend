<?php

namespace Core;

use ZfcUser\Controller\Plugin\ZfcUserAuthentication;
use Core\Service\VocationService;
use Core\Service\ModuleTypeService;
use Core\Service\GradingTypeService;
use Core\Service\ModuleService;
use Core\Service\SubjectService;

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

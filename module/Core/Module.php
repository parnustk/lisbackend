<?php

namespace Core;

use ZfcUser\Controller\Plugin\ZfcUserAuthentication;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [

                'sample_service' => function ($serviceManager) {
                    $t = new \Core\Service\SampleService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'vocation_service' => function ($serviceManager) {
                    $t = new \Core\Service\VocationService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'moduletype_service' => function ($serviceManager) {
                    $t = new \Core\Service\ModuleTypeService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'gradingtype_service' => function ($serviceManager) {
                    $t = new \Core\Service\GradingTypeService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                'module_service' => function ($serviceManager) {
                    $t = new \Core\Service\ModuleService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
            ],
        ];
    }

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

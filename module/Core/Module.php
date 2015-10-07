<?php
namespace Core;

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

                'sample_service' => function ($serviceManager)
                {
                    $t = new \Core\Service\SampleService();
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $t->setEntityManager($entityManager);
                    return $t;
                },
                        
            ],
        ];
    }
}

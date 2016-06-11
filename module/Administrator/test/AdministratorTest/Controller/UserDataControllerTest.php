<?php

/**
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\UserDataController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of UserDataControllerTest
 *
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class UserDataControllerTest extends UnitHelpers
{
    protected function setUp()
    {
        $this->controller = new UserDataController();
        parent::setUp();
    }
    
    public function testGetWithAdminUser()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $administrator->getId());
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }
    
    public function testUpdateSelfCreated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $repository = $this->em->getRepository('Core\Entity\Administrator');

        $entity = $repository->Create([
            'firstName' => 'firstName' . uniqid(),
            'lastName' => 'lastName' . uniqid(),
            'personalCode' => 'code' . uniqid(),
            'email' => 'adminemail' . uniqid() . '@mail.ee',
            'createdBy' => $lisUser->getId()
        ]);

        $id = $entity->getId();

        $firstNameOld = $entity->getFirstName();
        $lastNameOld = $entity->getLastName();
        $codeOld = $entity->getPersonalCode();
        $emailOld = $entity->getEmail();


        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'firstName' => 'Updated',
            'lastName' => 'Updated',
            'personalCode' => uniqid(),
            'email' => uniqid() . '@asd.ee',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Administrator')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $firstNameOld, $r->getFirstName()
        );
        $this->assertNotEquals(
                $lastNameOld, $r->getLastName()
        );
        $this->assertNotEquals(
                $codeOld, $r->getPersonalCode()
        );

        $this->assertNotEquals(
                $emailOld, $r->getEmail()
        );
    }
    
    public function testUpdateNotSelfCreated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $repository = $this->em->getRepository('Core\Entity\Administrator');

        $anotherAdministrator = $this->CreateAdministrator();
        $anotherLisUser = $this->CreateAdministratorUser($anotherAdministrator);

        $entity = $repository->Create([
            'firstName' => 'firstName' . uniqid(),
            'lastName' => 'lastName' . uniqid(),
            'personalCode' => 'code' . uniqid(),
            'email' => 'adminemail' . uniqid() . '@mail.ee',
            'createdBy' => $anotherLisUser->getId()
        ]);

        $id = $entity->getId();


        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'firstName' => 'Updated',
            'lastName' => 'Updated',
            'personalCode' => uniqid(),
            'email' => uniqid() . '@asd.ee',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }
}

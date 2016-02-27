<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * 
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AdministratorController;

/**
 * Description of AdministratorControllerTest
 *
 * @author Marten Kähr <marten@kahr.ee>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AdministratorControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new AdministratorController();
        parent::setUp();
    }

    /**
     * TEST row gets not created, then no POST body
     * 
     * NOT successful 
     */
    public function testCreateNoData()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(true, $result->success);
    }

    /**
     * Test that row gets created no user
     * 
     * should be successful
     */
    public function testCreateNoLisUser()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');

        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);

        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);

        $code = uniqid() . 'code';
        $this->request->getPost()->set("personalCode", $code);

        $email = uniqid() . '@code.ee';
        $this->request->getPost()->set("email", $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
    }

    /**
     * Test that row gets created no user
     * 
     * should be successful
     */
    public function testCreateWithLisUser()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');

        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);

        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);

        $code = uniqid() . 'code';
        $this->request->getPost()->set("personalCode", $code);

        $email = uniqid() . '@code.ee';
        $this->request->getPost()->set("email", $email);

        $this->request->getPost()->set("lisUser", $this->CreateLisUser()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
    }

    /**
     * TEST row gets read by id
     * 
     * should be successful
     */
    public function testGet()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAdministrator()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST rows get read
     * 
     * should be successful
     */
    public function testGetList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->CreateAdministrator();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * TEST row gets updated by id
     * 
     * should be successful
     */
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

        $this->PrintOut($result, false);

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

    /**
     * TEST row gets updated by id
     * 
     * should be NOT successful
     */
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

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }

    /**
     * TEST row gets deleted by id
     * 
     * should be successful
     */
    public function testDeleteSelfCreatedTrashed()
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

        $idOld = $entity->getId();
        $entity->setTrashed(1);

        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);


        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Administrator')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }

    /**
     * TEST row gets deleted by id
     * 
     * should be successful
     */
    public function testDeleteSelfCreatedNotTrashed()
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

        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('NOT_TRASHED', $result->message);
        
        //assert it is still in the database
        $deleted = $this->em
                ->getRepository('Core\Entity\Administrator')
                ->find($idOld);

        $this->assertEquals($entity, $deleted);
    }

}

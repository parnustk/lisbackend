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
use Doctrine\ORM\Query\ResultSetMapping;

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
     */
    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    /**
     * Test that row gets created no user
     */
    public function testCreateNoLisUser()
    {
        $this->request->setMethod('post');

        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);

        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);

        $code = uniqid() . 'code';
        $this->request->getPost()->set("code", $code);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    /**
     * Test that row gets created no user
     */
    public function testCreateWithLisUser()
    {
        $this->request->setMethod('post');

        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);

        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);

        $code = uniqid() . 'code';
        $this->request->getPost()->set("code", $code);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    /**
     * Test that row gets created no user
     */
    public function testCreateWithCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);

        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);

        $code = uniqid() . 'code';
        $this->request->getPost()->set("code", $code);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());

        /////
        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);
        ///////

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);

        $repository = $this->em->getRepository('Core\Entity\Administrator');
        $newAdministrator = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newAdministrator->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newAdministrator->getUpdatedBy()->getId());
    }

    public function testCreateWithCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');
        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);
        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);
        $code = uniqid() . 'code';
        $this->request->getPost()->set("code", $code);
        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
        $repository = $this->em->getRepository('Core\Entity\Administrator');
        $newAdministrator = $repository->find($result->data['id']);
        $this->assertNotNull($newAdministrator->getCreatedAt());
        $this->assertNotNull($newAdministrator->getUpdatedAt());
    }

    public function testCreateWithCryptedCode()
    {
        $this->request->setMethod('post');
        $firstName = uniqid() . 'firstName';
        $this->request->getPost()->set("firstName", $firstName);
        $lastName = uniqid() . 'lastName';
        $this->request->getPost()->set("lastName", $lastName);
        $code = '123456789' . uniqid();
        $this->request->getPost()->set("code", $code);
        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $repository = $this->em->getRepository('Core\Entity\Administrator');

        //get php 'Code' value
        $newAdministrator = $repository->find($result->data['id']);

        //get sql 'Code' calue from db
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("SELECT * FROM  Administrator WHERE  id = :id LIMIT 1");
        $statement->bindValue('id', $result->data['id']);
        $statement->execute();
        $r = $statement->fetch();


        $this->assertNotEquals($newAdministrator->getCode(), $r['code']);
    }

}

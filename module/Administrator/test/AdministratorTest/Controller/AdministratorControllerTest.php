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

//    /**
//     * TEST row gets not created, then no POST body
//     */
//    public function testCreateNoData()
//    {
//        $this->request->setMethod('post');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    /**
//     * Test that row gets created no user
//     */
//    public function testCreateNoLisUser()
//    {
//        $this->request->setMethod('post');
//
//        $firstName = uniqid() . 'firstName';
//        $this->request->getPost()->set("firstName", $firstName);
//
//        $lastName = uniqid() . 'lastName';
//        $this->request->getPost()->set("lastName", $lastName);
//
//        $code = uniqid() . 'code';
//        $this->request->getPost()->set("code", $code);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    /**
//     * Test that row gets created no user
//     */
//    public function testCreateWithLisUser()
//    {
//        $this->request->setMethod('post');
//
//        $firstName = uniqid() . 'firstName';
//        $this->request->getPost()->set("firstName", $firstName);
//
//        $lastName = uniqid() . 'lastName';
//        $this->request->getPost()->set("lastName", $lastName);
//
//        $code = uniqid() . 'code';
//        $this->request->getPost()->set("code", $code);
//
//        $lisUser = $this->CreateLisUser();
//        $this->request->getPost()->set("lisUser", $lisUser->getId());
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    /**
//     * Test that row gets created no user
//     */
//    public function testCreateWithCreatedByAndUpdatedBy()
//    {
//        $this->request->setMethod('post');
//
//        $firstName = uniqid() . 'firstName';
//        $this->request->getPost()->set("firstName", $firstName);
//
//        $lastName = uniqid() . 'lastName';
//        $this->request->getPost()->set("lastName", $lastName);
//
//        $code = uniqid() . 'code';
//        $this->request->getPost()->set("code", $code);
//
//        $lisUser = $this->CreateLisUser();
//        $this->request->getPost()->set("lisUser", $lisUser->getId());
//
//        /////
//        $lisUserCreates = $this->CreateLisUser();
//        $lisUserCreatesId = $lisUserCreates->getId();
//        $this->request->getPost()->set("createdBy", $lisUserCreatesId);
//
//        $lisUserUpdates = $this->CreateLisUser();
//        $lisUserUpdatesId = $lisUserUpdates->getId();
//        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);
//        ///////
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//
//        $repository = $this->em->getRepository('Core\Entity\Administrator');
//        $newAdministrator = $repository->find($result->data['id']);
//        $this->assertEquals($lisUserCreatesId, $newAdministrator->getCreatedBy()->getId());
//        $this->assertEquals($lisUserUpdatesId, $newAdministrator->getUpdatedBy()->getId());
//    }
//
//    public function testCreateWithCreatedAtAndUpdatedAt()
//    {
//        $this->request->setMethod('post');
//        $firstName = uniqid() . 'firstName';
//        $this->request->getPost()->set("firstName", $firstName);
//        $lastName = uniqid() . 'lastName';
//        $this->request->getPost()->set("lastName", $lastName);
//        $code = uniqid() . 'code';
//        $this->request->getPost()->set("code", $code);
//        $lisUser = $this->CreateLisUser();
//        $this->request->getPost()->set("lisUser", $lisUser->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//        $repository = $this->em->getRepository('Core\Entity\Administrator');
//        $newAdministrator = $repository->find($result->data['id']);
//        $this->assertNotNull($newAdministrator->getCreatedAt());
//        $this->assertNotNull($newAdministrator->getUpdatedAt());
//    }
//
//    public function testCreateWithCryptedCode()
//    {
//        $this->request->setMethod('post');
//        $firstName = uniqid() . 'firstName';
//        $this->request->getPost()->set("firstName", $firstName);
//        $lastName = uniqid() . 'lastName';
//        $this->request->getPost()->set("lastName", $lastName);
//        $code = '123456789' . uniqid();
//        $this->request->getPost()->set("code", $code);
//        $lisUser = $this->CreateLisUser();
//        $this->request->getPost()->set("lisUser", $lisUser->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->PrintOut($result, false);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $repository = $this->em->getRepository('Core\Entity\Administrator');
//
//        //get php 'Code' value
//        $newAdministrator = $repository->find($result->data['id']);
//
//        //get sql 'Code' calue from db
//        $connection = $this->em->getConnection();
//        $statement = $connection->prepare("SELECT * FROM  Administrator WHERE  id = :id LIMIT 1");
//        $statement->bindValue('id', $result->data['id']);
//        $statement->execute();
//        $r = $statement->fetch();
//
//
//        $this->assertNotEquals($newAdministrator->getCode(), $r['code']);
//    }

    /**
     * TEST row gets read by id
     */
    public function testGet() {
        
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAdministrator()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1,$result->success);
        $this->PrintOut($result, false);
    }
    
    /**
     * TEST rows get read
     */
    public function testGetList()
    {
        $this->CreateAdministrator();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }
    
    /**
     * TEST row gets updated by id
     */
    public function testUpdate()
    {
        //create student
        $entity = $this->CreateAdministrator();
        $id = $entity->getId();

        $firstNameOld = $entity->getFirstName();
        $lastNameOld = $entity->getLastName();
        $codeOld = $entity->getCode();
        
        
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'firstName' => 'Updated',
            'lastName' => 'Updated',
            'code' => uniqid(),
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

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
                $codeOld, $r->getCode()
        );
        $this->PrintOut($result, true);
    }
    
    /**
     * TEST row gets deleted by id
     */
    public function testDelete()
    {
        $entity = $this->CreateStudent();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Student')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }
}

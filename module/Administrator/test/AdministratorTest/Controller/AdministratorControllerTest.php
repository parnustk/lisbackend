<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AdministratorController;

/**
 * Description of AdministratorControllerTest
 *
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

}

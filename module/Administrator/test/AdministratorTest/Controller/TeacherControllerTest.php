<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\TeacherController;

/**
 * @author juhan
 */
class TeacherControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new TeacherController();
        parent::setUp();
    }

    /**
     * testing create without a data
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
     * testing create with data
     */
    public function testCreate()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("firstName", "Firstname");
        $this->request->getPost()->set("lastName", "Lastname");
        $this->request->getPost()->set("email", "email");
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    /**
     * testing GET
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateTeacher()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, FALSE);
    }

    /**
     * testing GetList
     */
    public function testGetList()
    {
        $this->CreateTeacher();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    /**
     * testing PUT
     */
    public function testUpdate()
    {
        $teacher = $this->CreateTeacher();
        $firstNameOld = $teacher->getFirstName();
        $lastNameOld = $teacher->getLastName();
        $codeOld = $teacher->getCode();
        $emailOld = $teacher->getEmail();
        //prepare
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $teacher->getId());
        //set new data
        $firstName = uniqid() . "firstname";
        $lastName = uniqid() . "lastname";
        $code = uniqid() . "code";
        $email = uniqid() . "email@tere.ee";
        //set new data
        $this->request->setContent(http_build_query([
            "firstName" => $firstName,
            "lastName" => $lastName,
            "code" => $code,
            "email" => $email
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertNotEquals($firstNameOld, $result->data["firstName"]);
        $this->assertNotEquals($lastNameOld, $result->data["lastName"]);
        $this->assertNotEquals($codeOld, $result->data["code"]);
        $this->assertNotEquals($emailOld, $result->data["email"]);
    }

    public function testDelete()
    {
        $teacherRepository = $this->em->getRepository("Core\Entity\Teacher");
        $entity = $this->CreateTeacher();
        $idOld = $entity->getId();
        $this->assertNull($teacherRepository->find($idOld)->getTrashed());

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);


        $this->PrintOut($result, false);
        $this->assertNotNull($teacherRepository->find($idOld)->getTrashed());
    }

}

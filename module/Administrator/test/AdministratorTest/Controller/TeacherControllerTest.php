<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\TeacherController;

/**
 * @author Juhan Kõks <juhankoks@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
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

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    /**
     * testing create with data
     */
    public function testCreate()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("personalCode", uniqid());
        $this->request->getPost()->set("firstName", "Firstname");
        $this->request->getPost()->set("lastName", "Lastname");
        $this->request->getPost()->set("email", "email");
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * testing with createdny and updateby fields
     */
    public function testCreateWithCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("personalCode", uniqid());
        $this->request->getPost()->set("firstName", "Firstname");
        $this->request->getPost()->set("lastName", "Lastname");
        $this->request->getPost()->set("email", "email");

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);
        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $repository = $this->em->getRepository('Core\Entity\Teacher');
        $newTeacher = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newTeacher->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newTeacher->getUpdatedBy()->getId());
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

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
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

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * testing PUT
     */
    public function testUpdate()
    {
        $teacher = $this->CreateTeacher();
        $firstNameOld = $teacher->getFirstName();
        $lastNameOld = $teacher->getLastName();
        $codeOld = $teacher->getPersonalCode();
        $emailOld = $teacher->getEmail();
        //prepare
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $teacher->getId());
        //set new data
        $firstName = uniqid() . "firstname";
        $lastName = uniqid() . "lastname";
        $code = uniqid() . "personalCode";
        $email = uniqid() . "email@tere.ee";
        //set new data
        $this->request->setContent(http_build_query([
            "firstName" => $firstName,
            "lastName" => $lastName,
            "personalCode" => $code,
            "email" => $email
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertNotEquals($firstNameOld, $result->data["firstName"]);
        $this->assertNotEquals($lastNameOld, $result->data["lastName"]);
        $this->assertNotEquals($codeOld, $result->data["personalCode"]);
        $this->assertNotEquals($emailOld, $result->data["email"]);
    }

    public function testDelete()
    {
        $entity = $this->CreateTeacher();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Teacher')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);
    }

}

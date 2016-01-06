<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\StudentController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);
/**
 * @author marten
 */
class StudentControllerTest extends UnitHelpers
{
    protected function setUp()
    {
        $this->controller = new StudentController();
        parent::setUp();
    }
    //put code here
    public function testCreate()
    {
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();
        $studentGroup = $this->CreateStudentGroup();
//        
        $this->request->setMethod('post');
        
        
        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('email', $email);
        
        $this->request->getPost()->set('studentGroup', $studentGroup);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->PrintOut($result, false);
        $this->assertEquals(1,$result->success);
    }
    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1,$result->success);
        $this->PrintOut($result, false);
    }
    public function testCreateNoFirstName()
    {
//        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();
        $studentGroup = $this->CreateStudentGroup();
//        
        $this->request->setMethod('post');
        
        
//        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('email', $email);
        
        $this->request->getPost()->set('studentGroup', $studentGroup);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->PrintOut($result, false);
        $this->assertNotEquals(1,$result->success);
    }
    public function testCreateNoLastName()
    {
        $firstName = 'studentFirstName' . uniqid();
//        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();
        $studentGroup = $this->CreateStudentGroup();
//        
        $this->request->setMethod('post');
        
        
        $this->request->getPost()->set('firstName', $firstName);
//        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('email', $email);
        
        $this->request->getPost()->set('studentGroup', $studentGroup);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->PrintOut($result, false);
        $this->assertNotEquals(1,$result->success);
    }
    public function testCreateNoCode()
    {
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
//        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();
        $studentGroup = $this->CreateStudentGroup();
//        
        $this->request->setMethod('post');
        
        
        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
//        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('email', $email);
        
        $this->request->getPost()->set('studentGroup', $studentGroup);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->PrintOut($result, false);
        $this->assertNotEquals(1,$result->success);
    }
    public function testCreateNoEmail()
    {
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
//        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();
        $studentGroup = $this->CreateStudentGroup();
//        
        $this->request->setMethod('post');
        
        
        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('code', $code);
//        $this->request->getPost()->set('email', $email);
        
        $this->request->getPost()->set('studentGroup', $studentGroup);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->PrintOut($result, false);
        $this->assertNotEquals(1,$result->success);
    }
    public function testCreateNoStudentGroup()
    {
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();
//        $studentGroup = $this->CreateStudentGroup();
//        
        $this->request->setMethod('post');
        
        
        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('email', $email);
        
//        $this->request->getPost()->set('studentGroup', $studentGroup);
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->PrintOut($result, false);
        $this->assertNotEquals(1,$result->success);
    }
}


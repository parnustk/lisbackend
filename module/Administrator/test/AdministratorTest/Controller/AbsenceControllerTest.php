<?php

/**
 * LIS development
 * Rest API ControllerTests
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * REST API ControllerTests
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new AbsenceController();
        parent::setUp();
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, (bool) $result->success);
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreate()
    {
        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST row gets not created
     */
    public function testCreateNoDescription()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testCreateNoStudent()
    {
        $this->request->setMethod('post');
        $description = 'Absence description' . uniqid();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    public function testCreateNoContactLesson()
    {
        $this->request->setMethod('post');
        $description = 'Absence description' . uniqid();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAbsence()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
//    public function testUpdate()
//    {
//        //create one to  update later on
//        $absence = $this->CreateAbsence();
//        $studentIdOld = $absence->getStudent()->getId();
//        $contactLessonIdOld = $absence->getContactLesson()->getId();
//        $absenceReason = $absence->getAbsenceReason()->getId();
//
//        //prepare request
//        $this->request->setMethod('put');
//        $this->routeMatch->setParam('id', $absence->getId());
//
//        //set new data
//        $teacher1 = $this->CreateTeacher();
//        $teacher2 = $this->CreateTeacher();
//        
//        $teachers = [
//            [
//                'id' => $teacher1->getId()
//            ],
//            [
//                'id' => $teacher2->getId()
//            ]
//        ];
//
//        $this->request->setContent(http_build_query([
//            'subject' => $this->CreateSubject()->getId(),
//            'studentGroup' => $this->CreateStudentGroup()->getId(),
//            "absenceReason" => $absenceReason,
//        ]));
//
//        //fire request
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//
//        $this->PrintOut($result, false);
//
//        $this->assertNotEquals($studentIdOld, $result->data['studentGroup']['id']);
//        $this->assertNotEquals($contactLessonIdOld, $result->data['subject']['id']);
//
//        foreach ($teachersOld as $teacherOld) {//no double check figured out, pure linear looping
//            foreach ($result->data['teacher'] as $teacherU) {
//                $this->assertNotEquals($teacherOld['id'], $teacherU['id']);
//            }
//        }
//    }

}

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\StudentGradeController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * StudentGradeControllerTest
 *
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class StudentGradeControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new StudentGradeController();
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
    public function testCreateWithContactLesson()
    {
        $notes = 'StudentGrade notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());
        $this->request->getPost()->set('teacher', $this->CreateTeacher()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreateWithModule()
    {
        $notes = 'StudentGrade notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('module', $this->CreateModule()->getId());
        $this->request->getPost()->set('teacher', $this->CreateTeacher()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreateWithSubjectRound()
    {
        $notes = 'StudentGrade notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('subjectRound', $this->CreateSubjectRound()->getId());
        $this->request->getPost()->set('teacher', $this->CreateTeacher()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreateWithIndependentWork()
    {
        $notes = 'StudentGrade notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('independentWork', $this->CreateIndependentWork()->getId());
        $this->request->getPost()->set('teacher', $this->CreateTeacher()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateWithNoSpecification()
    {
        $notes = 'StudentGrade notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('teacher', $this->CreateTeacher()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateWithIMultipleData()
    {
        $notes = 'StudentGrade notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('subjectRound', $this->CreateSubjectRound()->getId());
        $this->request->getPost()->set('independentWork', $this->CreateIndependentWork()->getId());
        $this->request->getPost()->set('teacher', $this->CreateTeacher()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateStudentGrade()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        $this->CreateStudentGrade();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testUpdate()
    {
        //create one to  update later on
        $studentGrade = $this->CreateStudentGrade();


        $studentIdOld = $studentGrade->getStudent()->getId();
        $contactLessonIdOld = $studentGrade->getContactLesson()->getId();
        $gradeChoiceIdOld = $studentGrade->getGradeChoice()->getId();
        $teacherIdOld = $studentGrade->getTeacher()->getId();


        $this->PrintOut($studentIdOld, false);
        $this->PrintOut($contactLessonIdOld, false);
        $this->PrintOut($gradeChoiceIdOld, false);
        $this->PrintOut($teacherIdOld, false);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentGrade->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'teacher' => $this->CreateTeacher()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);

        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
        $this->assertNotEquals($gradeChoiceIdOld, $result->data['gradeChoice']['id']);
        $this->assertNotEquals($teacherIdOld, $result->data['teacher']['id']);
    }

    public function testUpdateFalseData()
    {
        $data = [
            //'notes' => uniqid() . 'StudentGradeNotes',
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'teacher' => $this->CreateTeacher()->getId(),
            'contactLesson' => $this->CreateContactLesson()->getId(),
            //'independentWork' => $this->CreateIndependentWork()->getId(),
//            'module' => $this->CreateModule(),
            //'subjectRound' => $this->CreateSubjectRound(),
        ];
        //create one to  update later on
        $studentGrade = $this->CreateStudentGrade($data);

//        $studentIdOld = $studentGrade->getStudent()->getId();
//        $gradeChoiceIdOld = $studentGrade->getGradeChoice()->getId();
//        $teacherIdOld = $studentGrade->getTeacher()->getId();
//        $contactLessonIdOld = $studentGrade->getContactLesson()->getId();
//        //$independentWorkIdOld = $studentGrade->getIndependentWork()->getId();
//        $moduleIdOld = $studentGrade->getModule()->getId();

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentGrade->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            //'independentWork'=> $this->CreateIndependentWork()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'teacher' => $this->CreateTeacher()->getId(),
            'module' => $this->CreateModule()->getId(),
        ]));

        
        
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, true);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

}

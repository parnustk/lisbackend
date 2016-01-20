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
        $this->PrintOut($result, true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }
    
}

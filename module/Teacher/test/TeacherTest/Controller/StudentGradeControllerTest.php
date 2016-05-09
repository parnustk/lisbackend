<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace TeacherTest\Controller;

use Teacher\Controller\StudentGradeController;
use Zend\Json\Json;
use TeacherTest\UnitHelpers;

/**
 * Description of StudentGradeControllerTest
 *
 * @author Marten Kähr
 */
class StudentGradeControllerTest extends UnitHelpers
{
    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new StudentGradeController();
        parent::setUp();
    }
    
    /**
     * should be successful
     */
    public function testCreate()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //add data
        $notes = 'Notes' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());
        $this->request->getPost()->set('teacher', $teacher->getId());
        $this->request->getPost()->set('independentWork', $this->CreateIndependentWork()->getId());
//        $this->request->getPost()->set('module', $this->CreateModule()->getId());
//        $this->request->getPost()->set('subjectRound', $this->CreateSubjectRound()->getId());
//        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //make assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }
    
    public function testCreateGradeToSpecificStudent()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //add data
        $notes = 'Notes' . uniqid();
        $student = 4;
        $this->request->setMethod('post');
        $this->request->getPost()->set('notes', $notes);
        $this->request->getPost()->set('student', $student);
        $this->request->getPost()->set('gradeChoice', $this->CreateGradeChoice()->getId());
        $this->request->getPost()->set('teacher', $teacher->getId());
//        $this->request->getPost()->set('independentWork', $this->CreateIndependentWork()->getId());
        $this->request->getPost()->set('module', $this->CreateModule()->getId());
//        $this->request->getPost()->set('subjectRound', $this->CreateSubjectRound()->getId());
//        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, true);

        //make assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }
    
    /**
     * should be successful
     */
    public function testUpdateOwnCreated()
    {
        //create student user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create original data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
//        $module = $this->CreateModule();
//        $subjectRound = $this->CreateSubjectRound();
//        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $independentWork->getId(),
            'createdBy' => $lisUser->getId()
//            'module' => $module->getId(),
//            'subjectRound' => $subjectRound->getId(),
//            'contactLesson' => $contactLesson->getId()
        ]);

        $studentIdOld = $studentGrade->getStudent()->getId();
        $gradeChoiceIdOld = $studentGrade->getGradeChoice()->getId();
        $teacherIdOld = $studentGrade->getTeacher()->getId();
        $independentWorkIdOld = $studentGrade->getIndependentWork()->getId();
//        $moduleIdOld = $studentGrade->getModule()->getId();
//        $subjectRoundIdOld = $studentGrade->getSubjectRound()->getId();
//        $contactLessonIdOld = $studentGrade->getContactLesson()->getId();
        

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentGrade->getId());

        $this->request->setContent(http_build_query([
            'student' => $this->CreateStudent()->getId(),
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $this->CreateIndependentWork()->getId(),
//            'module' => $this->CreateModule()->getId(),
//            'subjectRound' => $this->CreateSubjectRound(),
//            'contactLesson' => $this->CreateContactLesson()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //for student should be the same - self related restriction
        $this->assertEquals($teacherIdOld, $result->data['teacher']['id']);
        
        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($independentWorkIdOld, $result->data['independentWork']['id']);
        $this->assertNotEquals($gradeChoiceIdOld, $result->data['gradeChoice']['id']);
//        $this->assertNotEquals($moduleIdOld, $result->data['module']['id']);
//        $this->assertNotEquals($subjectRoundIdOld, $result->data['subjectRound']['id']);
//        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
    }
    
    /**
     * should not be successful
     */
    public function testUpdateNotOwnCreated()
    {
        //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);
        
        //create other teacher user
        $otherTeacher = $this->CreateTeacher();
        $otherLisUser = $this->CreateTeacherUser($otherTeacher);
        
        //create original data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
//        $module = $this->CreateModule();
//        $subjectRound = $this->CreateSubjectRound();
//        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $otherTeacher->getId(),
            'independentWork' => $independentWork->getId(),
            'createdBy' => $otherLisUser->getId()
//            'module' => $module->getId(),
//            'subjectRound' => $subjectRound->getId(),
//            'contactLesson' => $contactLesson->getId()
        ]);

        $studentIdOld = $studentGrade->getStudent()->getId();
        $gradeChoiceIdOld = $studentGrade->getGradeChoice()->getId();
        $teacherIdOld = $studentGrade->getTeacher()->getId();
        $independentWorkIdOld = $studentGrade->getIndependentWork()->getId();
//        $moduleIdOld = $studentGrade->getModule()->getId();
//        $subjectRoundIdOld = $studentGrade->getSubjectRound()->getId();
//        $contactLessonIdOld = $studentGrade->getContactLesson()->getId();
        

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentGrade->getId());

        $this->request->setContent(http_build_query([
            'student' => $this->CreateStudent()->getId(),
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $this->CreateIndependentWork()->getId(),
//            'module' => $this->CreateModule()->getId(),
//            'subjectRound' => $this->CreateSubjectRound(),
//            'contactLesson' => $this->CreateContactLesson()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }
    
    /**
     * should be successful
     */
    public function testGet(){
         //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);
        
        //create data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
//        $module = $this->CreateModule();
//        $subjectRound = $this->CreateSubjectRound();
//        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $independentWork->getId(),
//            'module' => $module->getId(),
//            'subjectRound' => $subjectRound->getId(),
//            'contactLesson' => $contactLesson->getId()
        ]);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentGrade->getId());

        $this->request->setContent(http_build_query([
            'student' => $this->CreateStudent()->getId(),
            'gradeChoice' => $this->CreateGradeChoice()->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $this->CreateIndependentWork()->getId(),
//            'module' => $this->CreateModule()->getId(),
//            'subjectRound' => $this->CreateSubjectRound(),
//            'contactLesson' => $this->CreateContactLesson()->getId(),
        ]));
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);


        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $studentGrade->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }
    
    /**
     * should be successful
     */
    public function testGetList(){
         //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);
        
        //create generic, unrelated studentGrade
        $this->CreateStudentGrade();

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        //where even unrelated results are printed
        $this->assertGreaterThan(0,count($result->data));
    }
    
    /**
     * should be successful
     */
    public function testDeleteTrashedAndOwnCreated()
    {
        //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create original data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
//        $module = $this->CreateModule();
//        $subjectRound = $this->CreateSubjectRound();
//        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $independentWork->getId(),
            'createdBy' => $lisUser->getId(),
//            'module' => $module->getId(),
//            'subjectRound' => $subjectRound->getId(),
//            'contactLesson' => $contactLesson->getId()
            
        ]);        
        
        $studentGrade->setTrashed(1);
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);
        
        //store id for asserts
        $id = $studentGrade->getId();

        //fire request
        $this->routeMatch->setParam('id', $id);

        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\StudentGrade')
                ->find($id);
        $this->assertEquals(null, $deleted);
    }
    
    /**
     * should not be successful
     */
    public function testDeleteTrashedAndNotOwnCreated()
    {
        //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created teacheruser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);
        
        //create other teacher user
        $otherTeacher = $this->CreateTeacher();
        $otherLisUser = $this->CreateTeacherUser($otherTeacher);
        
        //create original data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
//        $module = $this->CreateModule();
//        $subjectRound = $this->CreateSubjectRound();
//        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $otherTeacher->getId(),
            'independentWork' => $independentWork->getId(),
            'createdBy' => $otherLisUser->getId()
//            'module' => $module->getId(),
//            'subjectRound' => $subjectRound->getId(),
//            'contactLesson' => $contactLesson->getId()
        ]);        
        $studentGrade->setTrashed(1);
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);
        
        $id = $studentGrade->getId();
        
        //prepare request
        $this->routeMatch->setParam('id', $id);

        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }
    
    /**
     * should not be successful
     */
    public function testDeleteNotTrashedAndOwnCreated()
    {
        //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);
        
        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create original data
        $notes = 'Notes' . uniqid();
        $student = $this->CreateStudent();
        $gradeChoice = $this->CreateGradeChoice();
        $independentWork = $this->CreateIndependentWork();
//        $module = $this->CreateModule();
//        $subjectRound = $this->CreateSubjectRound();
//        $contactLesson = $this->CreateContactLesson();
        
        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'gradeChoice' => $gradeChoice->getId(),
            'teacher' => $teacher->getId(),
            'independentWork' => $independentWork->getId(),
            'createdBy' => $lisUser->getId(),
//            'module' => $module->getId(),
//            'subjectRound' => $subjectRound->getId(),
//            'contactLesson' => $contactLesson->getId()
            
        ]);        
        
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);
        
        $id = $studentGrade->getId();
        
        //prepare request
        $this->routeMatch->setParam('id', $id);

        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('NOT_TRASHED', $result->message);
    }
}

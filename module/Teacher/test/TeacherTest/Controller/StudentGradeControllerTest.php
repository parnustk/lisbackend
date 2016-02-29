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
    
//    /**
//     * should be successful
//     */
//    public function testCreate()
//    {
//        //create and set correct teacheruser
//        $teacher = $this->CreateTeacher();
//        $lisUser = $this->CreateTeacherUser($teacher);
//
//        //set to current controller
//        $this->controller->setLisUser($lisUser);
//        $this->controller->setLisPerson($teacher);
//
//        //add data
//        $notes = 'Notes' . uniqid();
//        $this->request->setMethod('post');
//        $this->request->getPost()->set('notes', $notes);
//        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
//        $this->request->getPost()->set('gradechoice', $this->CreateContactLesson()->getId());
//        $this->request->getPost()->set('teacher', $teacher->getId());
//        $this->request->getPost()->set('independentwork', $this->CreateIndependentWork()->getId());
//        $this->request->getPost()->set('module', $this->CreateModule()->getId());
//        $this->request->getPost()->set('subjectround', $this->CreateSubjectRound()->getId());
//        $this->request->getPost()->set('contactlesson', $this->CreateContactLesson()->getId());
//
//        //fire request
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, false);
//
//        //make assertions
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(true, (bool) $result->success);
//    }
    
    
}

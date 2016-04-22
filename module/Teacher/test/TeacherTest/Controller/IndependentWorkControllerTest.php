<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace TeacherTest\Controller;

use Teacher\Controller\IndependentWorkController;
use Zend\Json\Json;
use TeacherTest\UnitHelpers;
use DateTime;

/**
 * Restrictions for student role:
 * 
 * YES getList
 * YES get
 * YES create
 * YES update - OWN CREATED
 * YES delete - OWN CREATED
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class IndependentWorkControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new IndependentWorkController();
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

        
        $this->request->setMethod('post');
        $this->request->getPost()->set("duedate", (new DateTime)->format('Y-m-d'));
        $this->request->getPost()->set("name", uniqid() . 'Name');
        $this->request->getPost()->set("description", uniqid() . 'Description');
        $this->request->getPost()->set("durationAK", (rand(1, 10) * 2));
        $this->request->getPost()->set("subjectRound", $this->CreateSubjectRound());
        $this->request->getPost()->set("teacher", $teacher->getId());
        $this->request->getPost()->set("student", $this->CreateStudent()->getId());
        //$this->request->getPost()->set("studentGrade", $this->CreateStudentGrade()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);
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

        //create independentWork with teacheruser
        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();
        //$teacher = $this->CreateTeacher();

        $independentWork = $this->CreateIndependentWork([
            //'name' => uniqid() . 'Name',
            //'duedate' => new \DateTime,
            //'description' => uniqid() . 'Description',
            //'durationAK' => (int) uniqid(),
            //'subjectRound' => $subjectRound->getId(),
            //'teacher' => $teacher->getId(),
            //'student' => $student->getId(),
            //'createdBy' => $lisUser->getId(),

            "duedate" => (new DateTime)->format('Y-m-d'),
            "name" => uniqid() . 'Name',
            "description" => uniqid() . 'Description',
            "durationAK" => (rand(1, 10) * 2),
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $teacher->getId(),
            "student" => $student->getId(),
            "createdBy" => $lisUser->getId(),
        ]);

        $subjectRoundIdOld = $independentWork->getSubjectRound()->getId();
        $studentIdOld = $independentWork->getStudent()->getId();
        $teacherIdOld = $independentWork->getTeacher()->getId();


        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $independentWork->getId());

        $this->request->setContent(http_build_query([
            'subjectRound' => $this->CreateSubjectRound()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'teacher' => $teacher->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //make assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);

        $this->assertNotEquals($subjectRoundIdOld, $result->data['subjectRound']['id']);
        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        //$this->assertNotEquals($teacherIdOld, $result->data['teacher']['id']);
    }

    /**
     * should NOT be  successful
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

        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();
        //$teacher = $this->CreateTeacher();
        //$studentGrade = $this->CreateStudentGrade();

        $independentWork = $this->CreateIndependentWork([
            "duedate" => (new DateTime)->format('Y-m-d'),
            "name" => uniqid() . 'Name',
            "description" => uniqid() . 'Description',
            "durationAK" => (rand(1, 10) * 2),
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $otherTeacher->getId(),
            "student" => $student->getId(), //created by some other lisUser
            "createdBy" => $otherLisUser->getId()
        ]);

        $subjectRoundIdOld = $independentWork->getSubjectRound()->getId();
        $studentIdOld = $independentWork->getStudent()->getId();
        $teacherIdOld = $independentWork->getTeacher()->getId();
        
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $independentWork->getId());

        $this->request->setContent(http_build_query([
            "subjectRound" => $this->CreateSubjectRound()->getId(),
            "student" => $this->CreateStudent()->getId(),
            "teacher" => $teacher->getId(),
            //"studentGrade" => $studentGrade()->getId(),
        ]));


        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }

    public function testGetList()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create generic, unrelated independentWork
        $this->CreateIndependentWork();

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        //do assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //where even unrelated results are printed
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * should be successful
     */
    public function testGet()
    {
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();
        $teacher = $this->CreateTeacher();
        //$studentGrade = $this->CreateStudentGrade();
        //create other teacher user

        $independentWork = $this->CreateIndependentWork([
            //"name" => uniqid() . 'Name',
            "duedate" => (new DateTime)->format('Y-m-d'),
            "name" => uniqid() . 'Name',
            "description" => uniqid() . 'Description',
            "durationAK" => (rand(1, 10) * 2),
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $teacher->getId(),
            "student" => $student->getId(), //created by some other lisUser
        ]);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $independentWork->getId());

        $this->request->setContent(http_build_query([
            'subjectRound' => $this->CreateSubjectRound()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'teacher' => $teacher->getId(),
            //'studentGrade' => $this->CreateStudentGrade()->getId(),
        ]));

        $this->em->persist($independentWork);
        $this->em->flush($independentWork);


        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateIndependentWork()->getId());
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
    public function testDeleteTrashedAndOwnCreated()
    {
        //create teacher user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();

        //create original data


        $independentWork = $this->CreateIndependentWork([
            "duedate" => (new DateTime)->format('Y-m-d'),
            "name" => uniqid() . 'Name',
            "description" => uniqid() . 'Description',
            "durationAK" => (rand(1, 10) * 2),
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $teacher->getId(),
            "student" => $student->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $independentWork->setTrashed(1);
        $this->em->persist($independentWork);
        $this->em->flush($independentWork);

        //store id for asserts
        $id = $independentWork->getId();

        //fire request
        $this->routeMatch->setParam('id', $id);

        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\IndependentWork')
                ->find($id);

        $this->assertEquals(null, $deleted);
    }

    /**
     * should not be NOT successful
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

        //create indpendentWork with teacheruser
        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();
        //$teacher = $this->CreateTeacher();


        $independentWork = $this->CreateIndependentWork([
            "duedate" => (new DateTime)->format('Y-m-d'),
            "name" => uniqid() . 'Name',
            "description" => uniqid() . 'Description',
            "durationAK" => (int) uniqid(),
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $otherTeacher->getId(),
            "student" => $student->getId(),
            "createdBy" => $otherLisUser->getId()
        ]);

        //set independentWork trashed
        $independentWork->setTrashed(1);
        $this->em->persist($independentWork);
        $this->em->flush($independentWork);

        $id = $independentWork->getId();

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

        //test if it is not in the database anymore
        //$deleted = $this->em
        // ->getRepository('Core\Entity\IndependentWork')
        // ->find($id);
        // $this->assertNotEquals(null, $deleted);
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

       //create indpendentWork with teacheruser
        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();
        //$teacher = $this->CreateTeacher();


        $independentWork = $this->CreateIndependentWork([
            "duedate" => (new DateTime)->format('Y-m-d'),
            "name" => uniqid() . 'Name',
            "description" => uniqid() . 'Description',
            "durationAK" => (rand(1, 10) * 2),
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $teacher->getId(),
            "student" => $student->getId(),
            "createdBy" => $lisUser->getId()
        ]);

        
        $this->em->persist($independentWork);
        $this->em->flush($independentWork);
        
        $id = $independentWork->getId();
        
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


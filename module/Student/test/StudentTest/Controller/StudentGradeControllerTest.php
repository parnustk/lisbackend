<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace StudentTest\Controller;

use Student\Controller\StudentGradeController;
use Zend\Json\Json;
use StudentTest\UnitHelpers;

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
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
     * NOT ALLOWED
     */
    public function testCreate()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testUpdate()
    {
        $this->routeMatch->setParam('id', 1); //fake id no need for real id
        $this->request->setMethod('put');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testDelete()
    {
        $this->routeMatch->setParam('id', 1); //fake id no need for real id
        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * TEST row gets read by id
     */
    public function testGetSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $notes = 'StudentGrade notes' . uniqid();
        $teacher = $this->CreateTeacher()->getId();
        $gradeChoice = $this->CreateGradeChoice()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();

        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'teacher' => $teacher,
            'gradeChoice' => $gradeChoice,
            'contactLesson' => $contactLesson,
            'createdBy' => $lisUser->getId()//manualy set
        ]);

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

    public function testGetNotSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence related to this user
        //create absence with this user
        $notes = 'StudentGrade notes' . uniqid();
        $teacher = $this->CreateTeacher()->getId();
        $gradeChoice = $this->CreateGradeChoice()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();

        $anotherStudent = $this->CreateStudent();

        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $anotherStudent->getId(),
            'teacher' => $teacher,
            'gradeChoice' => $gradeChoice,
            'contactLesson' => $contactLesson,
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);


        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $studentGrade->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_RELATED_RESTRICTION', $result->message);
    }

    /**
     * should be NOT successful
     */
    public function testGetListSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create studentgrade related to this user
        //create studentgrade with this user
        $notes = 'StudentGrade notes' . uniqid();
        $teacher = $this->CreateTeacher()->getId();
        $gradeChoice = $this->CreateGradeChoice()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();

        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'teacher' => $teacher,
            'gradeChoice' => $gradeChoice,
            'contactLesson' => $contactLesson,
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //where can be only one student with this id, we just created only one above
        $this->assertEquals(1, count($result->data));
        $this->assertEquals($student->getId(), $result->data[0]['student']['id']);
    }

    /**
     * should be NOT successful
     */
    public function testGetListNotSelfRelated()
    {
        //TODO
        //create one studentgrade with one user
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create studentgrade related to this user
        //create studentgrade with this user
        $notes = 'StudentGrade notes' . uniqid();
        $teacher = $this->CreateTeacher()->getId();
        $gradeChoice = $this->CreateGradeChoice()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();

        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'teacher' => $teacher,
            'gradeChoice' => $gradeChoice,
            'contactLesson' => $contactLesson,
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade);

        //create another user set it to controller

        $anotherStudent = $this->CreateStudent();
        $anotherLisUser = $this->CreateStudentUser($anotherStudent);

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherStudent);

        //do assertions
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //with fresh student there can be no results
        $this->assertEquals(0, count($result->data));
    }

    public function testGetTrashedListSelfRelated()
    {
        //TODO
        //create one studentgrade with one user
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create studentgrade related to this user
        //create studentgrade with this user
        $notes = 'StudentGrade notes' . uniqid();
        $teacher = $this->CreateTeacher()->getId();
        $gradeChoice = $this->CreateGradeChoice()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();

        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'teacher' => $teacher,
            'gradeChoice' => $gradeChoice,
            'contactLesson' => $contactLesson,
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $studentGrade->setTrashed(1);
        $this->em->persist($studentGrade);
        $this->em->flush($studentGrade); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $studentGrade->getId()
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //limit is set to 1
        $this->assertEquals(1, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }
    
    public function testGetTrashedListNotSelfRelated()
    {
        //TODO
        //create one studentgrade with one user
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create studentgrade related to this user
        //create studentgrade with this user
        $notes = 'StudentGrade notes' . uniqid();
        $teacher = $this->CreateTeacher()->getId();
        $gradeChoice = $this->CreateGradeChoice()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();

        $studentGrade = $this->CreateStudentGrade([
            'notes' => $notes,
            'student' => $student->getId(),
            'teacher' => $teacher,
            'gradeChoice' => $gradeChoice,
            'contactLesson' => $contactLesson,
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $studentGrade->setTrashed(1);
        $this->em->persist($studentGrade);
        
        $this->em->flush($studentGrade); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $studentGrade->getId()
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }
        
        //create another user set it to controller

        $anotherStudent = $this->CreateStudent();
        $anotherLisUser = $this->CreateStudentUser($anotherStudent);

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherStudent);

        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //limit is set to 1
        $this->assertEquals(0, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }

}

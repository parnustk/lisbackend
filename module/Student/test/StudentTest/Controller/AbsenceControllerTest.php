<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace StudentTest\Controller;

use Student\Controller\AbsenceController;
use StudentTest\UnitHelpers;

/**
 * Restrictions for student role:
 * 
 * YES getList - OWN RELATED
 * YES get - OWN RELATED
 * YES create - OWN RELATED
 * YES update - OWN CREATED RELATED ?PERIOD
 * YES delete - OWN CREATED RELATED ?PERIOD
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AbsenceControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new AbsenceController();
        parent::setUp();
    }

    /**
     * should be successful
     */
    public function testCreate()
    {
        //start create studentuser
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $student->getId());
        $this->request->getPost()->set('absenceReason', $this->CreateAbsenceReason()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * should be NOT successful
     */
    public function testCreateForAnotherStudent()
    {
        //start create existing studentuser
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $description = 'Absence description' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('description', $description);

        //NB! different student
        $anotherStudent = $this->CreateStudent();
        $this->request->getPost()->set('student', $anotherStudent->getId());

        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

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
    public function testUpdate()
    {
        //create student user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $studentIdOld = $student->getId();
        $contactLessonIdOld = $absence->getContactLesson()->getId();
        $absenceReasonIdOld = $absence->getAbsenceReason()->getId();

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'student' => $student->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //for student should be the same - self related restriction
        $this->assertEquals($studentIdOld, $result->data['student']['id']);

        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
        $this->assertNotEquals($absenceReasonIdOld, $result->data['absenceReason']['id']);
    }

    /**
     * should be NOT successful
     */
    public function testUpdateNotSelfRelated()
    {
        //create student user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);
        //now we have created studentuser
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'student' => $this->CreateStudent()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_RELATED_RESTRICTION', $result->message);
    }

    /**
     * should be NOT successful
     */
    public function testUpdateNotSelfCreated()
    {
        //Create absence with one user
        //create student user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);


        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        //try to update absence with another user
        $anotherStudent = $this->CreateStudent();
        $anotherLisUser = $this->CreateStudentUser($anotherStudent);

        //now we have created another studentuser
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherStudent);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            //leave student correct
            'student' => $student->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
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
    public function testDeleteTrashedAndSelfCreated()
    {
        //create and set user
        //create student user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence and set trashed to 1
        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $absence->setTrashed(1);
        $this->em->persist($absence);
        $this->em->flush($absence);

        $id = $absence->getId();

        //delete
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
                ->getRepository('Core\Entity\Absence')
                ->find($id);

        $this->assertEquals(null, $deleted);
    }

    /**
     * should be NOT successful
     */
    public function testDeleteTrashedNotSelfCreated()
    {
        //create and set user
        //create student user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence and set trashed to 1
        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $absence->setTrashed(1);
        $this->em->persist($absence);
        $this->em->flush($absence);

        $id = $absence->getId();

        //set another user
        //create student user
        $anotherStudent = $this->CreateStudent();
        $anotherLisUser = $this->CreateStudentUser($anotherStudent);

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherStudent);

        //delete
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }

    /**
     * should be successful
     */
    public function testGetSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence related to this user
        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($absence);
        $this->em->flush($absence);


        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $absence->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * should be NOT successful
     */
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
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $anotherStudent = $this->CreateStudent();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $anotherStudent->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($absence);
        $this->em->flush($absence);


        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $absence->getId());
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

        //create absence related to this user
        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($absence);
        $this->em->flush($absence);

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
        //create one absence with one user
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //create absence related to this user
        //create absence with this user
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()//manualy set
        ]);
        $this->em->persist($absence);
        $this->em->flush($absence);

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

}

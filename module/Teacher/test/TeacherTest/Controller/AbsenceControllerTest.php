<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace TeacherTest\Controller;

use Teacher\Controller\AbsenceController;
use TeacherTest\UnitHelpers;

/**
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
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //add data
        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //make assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, (bool) $result->success);
    }

    /**
     * should be successful
     */
    public function testUpdateSelfCreated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create absence with teacheruser
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $this->CreateStudent()->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $contactLessonIdOld = $absence->getContactLesson()->getId();
        $absenceReasonIdOld = $absence->getAbsenceReason()->getId();

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //make assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, (bool) $result->success);

        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
        $this->assertNotEquals($absenceReasonIdOld, $result->data['absenceReason']['id']);
    }

    /**
     * should be NOT successful
     */
    public function testUpdateNotSelfCreated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create absence with teacheruser
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        //create another teacher user
        $teacherAnother = $this->CreateTeacher();
        $lisUserAnother = $this->CreateTeacherUser($teacherAnother);

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $this->CreateStudent()->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUserAnother->getId()//created by some other lisUser
        ]);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //make assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, (bool) $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }

    /**
     * should be successful
     */
    public function testDeleteSelfCreatedTrashedAbsence()
    {
//        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create absence with teacheruser
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $this->CreateStudent()->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        //set absence trashed
        $absence->setTrashed(1);
        $this->em->persist($absence);
        $this->em->persist($absence);

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
    public function testDeleteNotSelfCreatedTrashedAbsence()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create absence with teacheruser
        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();


        //create another teacher user
        $teacherAnother = $this->CreateTeacher();
        $lisUserAnother = $this->CreateTeacherUser($teacherAnother);

        $absence = $this->CreateAbsence([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $this->CreateStudent()->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUserAnother->getId()
        ]);

        //set absence trashed
        $absence->setTrashed(1);
        $this->em->persist($absence);
        $this->em->persist($absence);

        $id = $absence->getId();

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


        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Absence')
                ->find($id);

        $this->assertNotEquals(null, $deleted);
    }

    /**
     * should be successful
     */
    public function testGetList()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->CreateAbsence();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * should be successful
     */
    public function testGet()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAbsence()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

}

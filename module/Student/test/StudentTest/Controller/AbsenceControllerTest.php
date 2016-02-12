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
use Zend\Json\Json;
use StudentTest\UnitHelpers;

/**
 * Restrictions for student role:
 * 
 * YES getList - OWN RELATED
 * YES get - OWN RELATED
 * YES create - OWN RELATED
 * YES update - OWN CREATED ?PERIOD
 * YES delete - OWN CREATED ?PERIOD
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
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreate()
    {
        //start create existing studentuser

        $student = $this->CreateStudent();
        $data = [
            'personalCode' => $student->getPersonalCode(),
            'password' => uniqid(),
            'email' => uniqid() . '@asd.ee',
        ];
        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($data);
        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

        //now we have created studentuser
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $description = 'Absence description' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $student->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateForAnotherStudent()
    {
        //start create existing studentuser
        $student = $this->CreateStudent();
        $data = [
            'personalCode' => $student->getPersonalCode(),
            'password' => uniqid(),
            'email' => uniqid() . '@asd.ee',
        ];
        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($data);
        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

        //now we have created studentuser
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $description = 'Absence description' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('description', $description);

        //different student
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());

        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }

    public function testUpdate()
    {
        //create student user
        $student = $this->CreateStudent();
        $data = [
            'personalCode' => $student->getPersonalCode(),
            'password' => uniqid(),
            'email' => uniqid() . '@asd.ee',
        ];
        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($data);
        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

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

        $studentIdOld = $student->getId();
        $contactLessonIdOld = $absence->getContactLesson()->getId();
        $absenceReasonIdOld = $absence->getAbsenceReason()->getId();
        $this->PrintOut($studentIdOld, false);
        $this->PrintOut($contactLessonIdOld, false);
        $this->PrintOut($absenceReasonIdOld, false);

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

        $this->assertEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
        $this->assertNotEquals($absenceReasonIdOld, $result->data['absenceReason']['id']);
    }

    public function testUpdateNotSelfRelated()
    {
        //create student user
        $student = $this->CreateStudent();
        $data = [
            'personalCode' => $student->getPersonalCode(),
            'password' => uniqid(),
            'email' => uniqid() . '@asd.ee',
        ];
        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($data);

        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

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

    public function testUpdateNotSelfCreated()
    {
        $this->assertEquals(1, 2);
    }

}

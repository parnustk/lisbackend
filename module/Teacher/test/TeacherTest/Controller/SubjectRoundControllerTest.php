<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace TeacherTest\Controller;

use Teacher\Controller\SubjectRoundController;
use Zend\Json\Json;
use TeacherTest\UnitHelpers;

/**
 * @author Arnold Tserepov <tserepov@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRoundControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new SubjectRoundController();
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
     * TEST rows get read
     */
    public function testGetListSelfRelated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create one to get first
        $this->CreateSubjectRound([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
        ]);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result->message, true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->assertGreaterThan(0, count($result->data));
    }

    public function testGetListNotSelfRelated()
    {
        //TODO
        //create one studentgrade with one user
        //create user
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        //create one to get first
        $subjectRound = $this->CreateSubjectRound([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
        ]);

        $this->em->persist($subjectRound);
        $this->em->flush($subjectRound);

        //create another user set it to controller

        $anotherTeacher = $this->CreateTeacher();
        $anotherLisUser = $this->CreateTeacherUser($anotherTeacher);

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherTeacher);

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

    /**
     * TEST row gets read by id
     */
    public function testGetSelfRelated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $subjectRound = $this->CreateSubjectRound([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
        ]);

        $this->em->persist($subjectRound);
        $this->em->flush($subjectRound);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $subjectRound->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testGetNotSelfRelated()
    {
        
    }

    public function testGetTrashedListSelfRelated()
    {
        
    }

    public function testGetTrashedListNotSelfRelated()
    {
        
    }

}

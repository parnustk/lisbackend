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
            'status' => 1,
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
            'createdBy' => $lisUser->getId()
        ]);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result->message, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * in teacher no restrictions at the moment
     * should be successful
     */
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
            'status' => 1,
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
            'createdBy' => $lisUser->getId()
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
//        $this->assertEquals(1, count($result->data));
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
            'status' => 1,
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
            'createdBy' => $lisUser->getId()
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

    /**
     * Restriction "SELF_RELATED_RESTRICTION"
     * Should NOT be successful
     */
    public function testGetNotSelfRelated()
    {
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $anotherTeacher = $this->CreateTeacher();

        $subjectRound = $this->CreateSubjectRound([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $anotherTeacher->getId()],
            ],
            'createdBy' => $lisUser->getId()//manualy set
        ]);

        $this->em->persist($subjectRound);
        $this->em->flush($subjectRound);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $subjectRound->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_RELATED_RESTRICTION', $result->message);
    }

    public function testGetTrashedListSelfRelated()
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
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
            'createdBy' => $lisUser->getId()
        ]);

        $subjectRound->setTrashed(1);
        $this->em->persist($subjectRound);
        $this->em->flush($subjectRound); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $subjectRound->getId()
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
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $subjectRound = $this->CreateSubjectRound([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
            'createdBy' => $lisUser->getId()
        ]);

        $subjectRound->setTrashed(1);
        $this->em->persist($subjectRound);
        $this->em->flush($subjectRound); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $subjectRound->getId()
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

        $anotherTeacher = $this->CreateTeacher();
        $anotherLisUser = $this->CreateTeacherUser($anotherTeacher);

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($anotherLisUser);
        $this->controller->setLisPerson($anotherTeacher);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //limit is set to 1
//        $this->assertEquals(0, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }
    
    /**
     * in teacher no restrictions at the moment
     * should be successful
     */
    public function testGetListDiaryData()
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
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            'teacher' => [
                ['id' => $teacher->getId()],
            ],
            'createdBy' => $lisUser->getId()
        ]);
        $where = [
            'subjectRound' => (object)['id' => 1],
            'studentGroup' => (object)['id' => 1],
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=10000&diaryview=diaryview&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        //now we have created another studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        //$this->assertEquals(1, $result->success);

    }
}

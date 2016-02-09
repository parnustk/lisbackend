<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectRoundController;
use Zend\Json\Json;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRoundControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectRoundController();
        parent::setUp();
    }

    /**
     * Imitate POST request
     */
    public function testCreate()
    {
        $this->request->setMethod('post');

        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());

        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());

        $teacher = [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ];

        $this->request->getPost()->set("teacher", $teacher);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);    
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testCreateNoSubject()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("studentGroup", $this->CreateStudentGroup()->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testCreateNoStudentGroup()
    {
        $this->request->setMethod('post');
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testCreateNoTeacher()
    {
        $this->request->setMethod('post');
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateSubjectRound()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);     
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
    }

    public function testUpdate()
    {
        //create one to  update later on
        $subjectRound = $this->CreateSubjectRound();
        $studentGroupIdOld = $subjectRound->getStudentGroup()->getId();
        $subjectIdOld = $subjectRound->getSubject()->getId();

        $teachersOld = [];
        foreach ($subjectRound->getTeacher() as $teacherOld) {
            $teachersOld[] = [
                'id' => $teacherOld->getId()
            ];
        }

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $subjectRound->getId());

        //set new data
        $teacher1 = $this->CreateTeacher();
        $teacher2 = $this->CreateTeacher();
        
        $teachers = [
            [
                'id' => $teacher1->getId()
            ],
            [
                'id' => $teacher2->getId()
            ]
        ];

        $this->request->setContent(http_build_query([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            "teacher" => $teachers,
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->assertNotEquals($studentGroupIdOld, $result->data['studentGroup']['id']);
        $this->assertNotEquals($subjectIdOld, $result->data['subject']['id']);

        foreach ($teachersOld as $teacherOld) {//no double check figured out, pure linear looping
            foreach ($result->data['teacher'] as $teacherU) {
                $this->assertNotEquals($teacherOld['id'], $teacherU['id']);
            }
        }
    }
    
    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateSubjectRound();
        $idOld = $entity->getId();
        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\SubjectRound')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {
        $entity = $this->CreateSubjectRound();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);
        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\SubjectRound')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);
    }

    public function testGetList()
    {
        $this->CreateSubjectRound();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();      
        $this->PrintOut($result, false);      
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    public function testGetListWithPaginaton()
    {
        $this->request->setMethod('get');

        //create 2 entities
        $this->CreateSubjectRound();
        $this->CreateSubjectRound();

        //set record limit to 1
        $q = 'page=1&limit=1';

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
    }
    
    public function testCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');
        
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $repository = $this->em->getRepository('Core\Entity\SubjectRound');
        $newModule = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newModule->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newModule->getUpdatedBy()->getId());
    }
    
    public function testCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');

        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $repository = $this->em->getRepository('Core\Entity\SubjectRound');
        $newSubjectRound = $repository->find($result->data['id']);
        $this->assertNotNull($newSubjectRound->getCreatedAt());
        $this->assertNull($newSubjectRound->getUpdatedAt());
    }
    
    public function testGetTrashedList()
    {

        //prepare one Module with trashed flag set up
        $entity = $this->CreateSubjectRound();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $entity->getId()
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
    
    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateSubjectRound();
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'trashed' => 1,
            'id' => $id
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $repository = $this->em
                ->getRepository('Core\Entity\SubjectRound')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $repository->getTrashed()
        );
    }

}

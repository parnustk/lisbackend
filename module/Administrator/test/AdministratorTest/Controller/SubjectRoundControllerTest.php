<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectRoundController;

/**
 * @author sander
 */
class SubjectRoundControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectRoundController();
        parent::setUp();
    }

//    /**
//     * Imitate POST request
//     */
//    public function testCreate()
//    {
//        $this->request->setMethod('post');
//
//        $subject = $this->CreateSubject();
//        $this->request->getPost()->set("subject", $subject->getId());
//
//        $studentGroup = $this->CreateStudentGroup();
//        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
//
//        $teacher = [
//            ['id' => $this->CreateTeacher()->getId()],
//            ['id' => $this->CreateTeacher()->getId()],
//        ];
//
//        $this->request->getPost()->set("teacher", $teacher);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testCreateNoData()
//    {
//        $this->request->setMethod('post');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testCreateNoSubject()
//    {
//        $this->request->setMethod('post');
//        $studentGroup = $this->CreateStudentGroup();
//        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testCreateNoStudentGroup()
//    {
//        $this->request->setMethod('post');
//        $subject = $this->CreateSubject();
//        $this->request->getPost()->set("subject", $subject->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testCreateNoTeacher()
//    {
//        $this->request->setMethod('post');
//        $subject = $this->CreateSubject();
//        $this->request->getPost()->set("subject", $subject->getId());
//        $studentGroup = $this->CreateStudentGroup();
//        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testGet()
//    {
//        $this->request->setMethod('get');
//        $this->routeMatch->setParam('id', $this->CreateSubjectRound()->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testUpdate()
//    {
//        //create one to  update later on
//        $subjectRound = $this->CreateSubjectRound();
//        $studentGroupIdOld = $subjectRound->getStudentGroup()->getId();
//        $subjectIdOld = $subjectRound->getSubject()->getId();
//
//        $teachersOld = [];
//        foreach ($subjectRound->getTeacher() as $teacherOld) {
//            $teachersOld[] = [
//                'id' => $teacherOld->getId()
//            ];
//        }
//
//        //prepare request
//        $this->request->setMethod('put');
//        $this->routeMatch->setParam('id', $subjectRound->getId());
//
//        //set new data
//        $teacher1 = $this->CreateTeacher();
//        $teacher2 = $this->CreateTeacher();
//        
//        $teachers = [
//            [
//                'id' => $teacher1->getId()
//            ],
//            [
//                'id' => $teacher2->getId()
//            ]
//        ];
//
//        $this->request->setContent(http_build_query([
//            'subject' => $this->CreateSubject()->getId(),
//            'studentGroup' => $this->CreateStudentGroup()->getId(),
//            "teacher" => $teachers,
//        ]));
//
//        //fire request
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//
//        $this->PrintOut($result, false);
//
//        $this->assertNotEquals($studentGroupIdOld, $result->data['studentGroup']['id']);
//        $this->assertNotEquals($subjectIdOld, $result->data['subject']['id']);
//
//        foreach ($teachersOld as $teacherOld) {//no double check figured out, pure linear looping
//            foreach ($result->data['teacher'] as $teacherU) {
//                $this->assertNotEquals($teacherOld['id'], $teacherU['id']);
//            }
//        }
//    }
//
//    public function testDelete()
//    {
//        $subjectRoundRepository = $this->em->getRepository('Core\Entity\SubjectRound');
//
//        //create one to delete later on
//        $entity = $this->CreateSubjectRound();
//        $idOld = $entity->getId();
//
//        $this->assertNull($subjectRoundRepository->find($idOld)->getTrashed());
//
//        $this->routeMatch->setParam('id', $entity->getId());
//        $this->request->setMethod('delete');
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//
//        $this->PrintOut($result, false);
//
//        $this->assertNotNull($subjectRoundRepository->find($idOld)->getTrashed());
//    }
    
    public function testGetList()
    {
        $this->CreateSubjectRound();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

}

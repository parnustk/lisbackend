<?php

/**
 * LIS development
 * Rest API ControllerTests
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * @author    Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\ContactLessonController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ContactLessonTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new ContactLessonController();
        parent::setUp();
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, (bool) $result->success);
    }

    public function testCreate()
    {
        $this->request->setMethod('post');
        $lessonDate = new \DateTime;
        $this->request->getPost()->set("lessonDate", $lessonDate);
        $description = uniqid() . ' Description for contactlesson';
        $this->request->getPost()->set("description", $description);
        $durationAK = 4;
        $this->request->getPost()->set("durationAK", $durationAK);

        $subjectRound = $this->CreateSubjectRound();

        $this->request->getPost()->set("subjectRound", $subjectRound->getId());

        $teachers = [];
        foreach ($subjectRound->getTeacher() as $teacher) {
            $teachers[] = [
                'id' => $teacher->getId()
            ];
        }
        $this->request->getPost()->set("teacher", $teachers);
        $result = $this->controller->dispatch($this->request);
        $this->PrintOut($result, false);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testUpdate()
    {
        //create one to  update later on
        $contactLesson = $this->CreateContactLesson();

        $lessonDateO = $contactLesson->getLessonDate()->format('Y-m-d H:i:s');
        $descriptionO = $contactLesson->getDescription();
        $durationAKO = $contactLesson->getDurationAK();
        $subjectRoundIdO = $contactLesson->getSubjectRound()->getId();

        $teachersO = [];
        foreach ($contactLesson->getTeacher() as $teacherO) {
            $teachersO[] = [
                'id' => $teacherO->getId()
            ];
        }

        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $contactLesson->getId());

        //start new data creation
        $lessonDate = (new \DateTime)
                ->add(new \DateInterval('P10D'))
                ->format('Y-m-d H:i:s');

        $description = ' Updated Description for contactlesson';
        $durationAK = 44;
        $subjectRound = $this->CreateSubjectRound();
        $teachers = [];
        foreach ($subjectRound->getTeacher() as $teacher) {
            $teachers[] = [
                'id' => $teacher->getId()
            ];
        }

        //set new data
        $this->request->setContent(http_build_query([
            "lessonDate" => $lessonDate,
            "description" => $description,
            "durationAK" => $durationAK,
            "subjectRound" => $subjectRound->getId(),
            "teacher" => $teachers
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);

        //start checking for changed data
        $this->assertNotEquals($lessonDateO, $result->data['lessonDate']);
        $this->assertNotEquals($descriptionO, $result->data['description']);
        $this->assertNotEquals($durationAKO, $result->data['durationAK']);
        $this->assertNotEquals($subjectRoundIdO, $result->data['subjectRound']['id']);

        //no double check figured out, pure linear looping
        foreach ($teachersO as $teacherO) {
            foreach ($result->data['teacher'] as $teacherU) {
                $this->assertNotEquals($teacherO['id'], $teacherU['id']);
            }
        }
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateContactLesson()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {

        $this->CreateContactLesson();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateContactLesson();
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
                ->getRepository('Core\Entity\ContactLesson')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {
        $entity = $this->CreateContactLesson();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\ContactLesson')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }

    public function testCreatedByAndUpdatedBy()
    {
//        $this->request->setMethod('post');
//
//        $description = 'ContactLesson description' . uniqid();
//        $lessonDate = 'ContactLesson lessonDate' . uniqid();
//        $durationAK = 'ContactLesson durationAK' . uniqid();
//
//        $contactLesson = $this->CreateContactLesson()->getId();
//
//        $absence = $this->CreateAbsence()->getId();
//        $subjectRound = $this->CreateSubjectRound()->getId();
//        
//        $teacher = $this->CreateTeacher()->getId();     
//        $rooms = $this->CreateRoom()->getId();
//        
//        $studentGrade = $this->CreateStudentGrade()->getId();
//
//        $this->request->getPost()->set('description', $description);
//        $this->request->getPost()->set('lessonDate', $lessonDate);
//        $this->request->getPost()->set('durationAK', $durationAK);
//        $this->request->getPost()->set('contactLesson', $contactLesson);
//        $this->request->getPost()->set('absence', $absence);
//        $this->request->getPost()->set('subjectRound', $subjectRound);
//        $teacher = [];
//        foreach ($subjectRound->getTeacher() as $teachers) {
//            $teacher[] = [
//                'id' => $teachers->getId()
//            ];
//        }
//        $rooms = [];
//        foreach ($subjectRound->getRooms() as $room) {
//            $rooms[] = [
//                'id' => $room->getId()
//            ];
//        }
//        $this->request->getPost()->set('studentGrade', $studentGrade);
//
//        $lisUserCreates = $this->CreateLisUser();
//        $lisUserCreatesId = $lisUserCreates->getId();
//        $this->request->getPost()->set("createdBy", $lisUserCreatesId);
//
//        $lisUserUpdates = $this->CreateLisUser();
//        $lisUserUpdatesId = $lisUserUpdates->getId();
//        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//
//        $this->PrintOut($result, false);
//
//        $repository = $this->em->getRepository('Core\Entity\ContactLesson');
//        $newContactLesson = $repository->find($result->data['id']);
//        $this->assertEquals($lisUserCreatesId, $newContactLesson->getCreatedBy()->getId());
//        $this->assertEquals($lisUserUpdatesId, $newContactLesson->getUpdatedBy()->getId());
    }

}

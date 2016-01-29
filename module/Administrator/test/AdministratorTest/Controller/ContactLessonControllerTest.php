<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
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

//    public function testCreateNoData()
//    {
//        $this->request->setMethod('post');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->PrintOut($result, false);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(false, (bool) $result->success);
//    }
//
//    public function testCreate()
//    {
//        $this->request->setMethod('post');
//        $lessonDate = new \DateTime;
//        $this->request->getPost()->set("lessonDate", $lessonDate);
//        $description = uniqid() . ' Description for contactlesson';
//        $this->request->getPost()->set("description", $description);
//        $durationAK = 4;
//        $this->request->getPost()->set("durationAK", $durationAK);
//
//        $subjectRound = $this->CreateSubjectRound();
//
//        $this->request->getPost()->set("subjectRound", $subjectRound->getId());
//
//        $teachers = [];
//        foreach ($subjectRound->getTeacher() as $teacher) {
//            $teachers[] = [
//                'id' => $teacher->getId()
//            ];
//        }
//        $this->request->getPost()->set("teacher", $teachers);
//        $result = $this->controller->dispatch($this->request);
//        $this->PrintOut($result, true);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }

    public function testUpdate()
    {
        //create one to  update later on
        $contactLesson = $this->CreateContactLesson();

        $lessonDateO = $contactLesson->getLessonDate()->format('Y-m-d H:i:s');
        $descriptionO = $contactLesson->getDescription();
        $durationAKO = $contactLesson->getDurationAK();
//        $subjectRoundIdO = $contactLesson->getSubjectRound()->getId();

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
        
        $insertData = [
            "lessonDate" => $lessonDate,
            "description" => $description,
            "durationAK" => $durationAK,
//            "subjectRound" => $subjectRound->getId(),
            "teacher" => $teachers
        ];
//        print_r($insertData);
        //set new data
        $this->request->setContent(http_build_query($insertData));

//        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //start checking for changed data
//        $this->assertNotEquals($lessonDateO, $result->data['lessonDate']);
//        $this->assertNotEquals($descriptionO, $result->data['description']);
//        $this->assertNotEquals($durationAKO, $result->data['durationAK']);
//        $this->assertNotEquals($subjectRoundIdO, $result->data['subjectRound']);
//
//        //no double check figured out, pure linear looping
//        foreach ($teachersO as $teacherO) {
//            foreach ($result->data['teacher'] as $teacherU) {
//                $this->assertNotEquals($teacherO['id'], $teacherU['id']);
//            }
//        }
    }

//    public function testGet()
//    {
//        $this->request->setMethod('get');
//        $this->routeMatch->setParam('id', $this->CreateContactLesson()->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//    }
//
//    public function testGetList()
//    {
//
//        $this->CreateContactLesson();
//        $this->request->setMethod('get');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->assertGreaterThan(0, count($result->data));
//        $this->PrintOut($result, false);
//    }
//
//    public function testDeleteNotTrashed()
//    {
//        $entity = $this->CreateContactLesson();
//        $idOld = $entity->getId();
//
//        $this->routeMatch->setParam('id', $entity->getId());
//        $this->request->setMethod('delete');
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->PrintOut($result, false);
//
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->em->clear();
//
//        //test it is not in the database anymore
//        $deleted = $this->em
//                ->getRepository('Core\Entity\ContactLesson')
//                ->Get($idOld);
//
//        $this->assertNotEquals(null, $deleted);
//    }
//
//    public function testDelete()
//    {
//        $entity = $this->CreateContactLesson();
//        $idOld = $entity->getId();
//        $entity->setTrashed(1);
//        $this->em->persist($entity);
//        $this->em->flush($entity);
//
//        $this->routeMatch->setParam('id', $entity->getId());
//        $this->request->setMethod('delete');
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->em->clear();
//
//        //test if it is not in the database anymore
//        $deleted = $this->em
//                ->getRepository('Core\Entity\ContactLesson')
//                ->Get($idOld);
//
//        $this->assertEquals(null, $deleted);
//
//        $this->PrintOut($result, false);
//    }
//
////    public function testCreatedByAndUpdatedBy()
////    {
//////        $this->request->setMethod('post');
//////
//////        $description = 'ContactLesson description' . uniqid();
//////        $lessonDate = new \DateTime;
//////        $durationAK = 5;
//////
//////        $contactLesson = $this->CreateContactLesson()->getId();
//////
//////        $absence = $this->CreateAbsence()->getId();
//////        $subjectRound = $this->CreateSubjectRound()->getId();
//////        $studentGrade = $this->CreateStudentGrade()->getId();
//////        
////////        $teacher = $this->CreateTeacher()->getId();     
////////        $rooms = $this->CreateRoom()->getId();
//////
//////        $this->request->getPost()->set('description', $description);
//////        $this->request->getPost()->set('lessonDate', $lessonDate);
//////        $this->request->getPost()->set('durationAK', $durationAK);
//////        $this->request->getPost()->set('contactLesson', $contactLesson);
//////        $this->request->getPost()->set('absence', $absence);
//////        $this->request->getPost()->set('subjectRound', $subjectRound);
////////        $teacher = [];
////////        foreach ($subjectRound->getTeacher() as $teachers) {
////////            $teacher[] = [
////////                'id' => $teachers->getId()
////////            ];
////////        }
////////        $rooms = [];
////////        foreach ($subjectRound->getRooms() as $room) {
////////            $rooms[] = [
////////                'id' => $room->getId()
////////            ];
////////        }
//////        $this->request->getPost()->set('studentGrade', $studentGrade);
//////
//////        $lisUserCreates = $this->CreateLisUser();
//////        $lisUserCreatesId = $lisUserCreates->getId();
//////        $this->request->getPost()->set("createdBy", $lisUserCreatesId);
//////
//////        $lisUserUpdates = $this->CreateLisUser();
//////        $lisUserUpdatesId = $lisUserUpdates->getId();
//////        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);
//////
//////        $result = $this->controller->dispatch($this->request);
//////        $response = $this->controller->getResponse();
//////
//////        $this->assertEquals(200, $response->getStatusCode());
//////        $this->assertEquals(1, $result->success);
//////
//////        $this->PrintOut($result, false);
//////
//////        $repository = $this->em->getRepository('Core\Entity\ContactLesson');
//////        $newContactLesson = $repository->find($result->data['id']);
//////        $this->assertEquals($lisUserCreatesId, $newContactLesson->getCreatedBy()->getId());
//////        $this->assertEquals($lisUserUpdatesId, $newContactLesson->getUpdatedBy()->getId());
////    }
//    
//    /**
//     * TEST rows get read by limit and page params
//     */
////    public function testGetListWithPaginaton()
////    {
////        $this->request->setMethod('get');
////
////        //set record limit to 1
////        $q = 'page=1&limit=1'; //imitate real param format
////        $params = [];
////        parse_str($q, $params);
////        foreach ($params as $key => $value) {
////            $this->request->getQuery()->set($key, $value);
////        }
////
////        $result = $this->controller->dispatch($this->request);
////        $response = $this->controller->getResponse();
////        $this->assertEquals(200, $response->getStatusCode());
////        $this->assertEquals(1, $result->success);
////        $this->assertLessThanOrEqual(1, count($result->data));
////        $this->PrintOut($result, false);
////    }
//    
//    public function testGetTrashedList()
//    {
//
//        //prepare one AbsenceReason with trashed flag set up
////        $entity = $this->CreateContactLesson();
////        $entity->setTrashed(1);
////        $this->em->persist($entity);
////        $this->em->flush($entity); //save to db with trashed 1
////        $where = [
////            'trashed' => 1,
////            'id' => $entity->getId()
////        ];
////        $whereJSON = Json::encode($where);
////        $whereURL = urlencode($whereJSON);
////        $whereURLPart = "where=$whereURL";
////        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format
////
////        $params = [];
////        parse_str($q, $params);
////        foreach ($params as $key => $value) {
////            $this->request->getQuery()->set($key, $value);
////        }
////
////        $this->request->setMethod('get');
////
////        $result = $this->controller->dispatch($this->request);
////        $response = $this->controller->getResponse();
////
////        $this->PrintOut($result, true);
////
////        $this->assertEquals(200, $response->getStatusCode());
////        $this->assertEquals(1, $result->success);
////
////        //limit is set to 1
////        $this->assertEquals(1, count($result->data));
////
////        //assert all results have trashed not null
////        foreach ($result->data as $value) {
////            $this->assertEquals(1, $value['trashed']);
////        }
//    }

}

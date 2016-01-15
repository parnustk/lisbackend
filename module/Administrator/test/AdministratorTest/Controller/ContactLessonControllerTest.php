<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\ContactLessonController;

/**
 * @author sander
 */
class ContactLessonTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new ContactLessonController();
        parent::setUp();
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
//        $this->request->setMethod('get');
//        $this->routeMatch->setParam('id', '1');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result->msg);
//            echo "\n--------------------------------------------------------\n";
//        } else {
////            print_r($result);
//        }
//        //print_r($s);
//        $this->assertEquals(1, $s);
    }

    public function testGetList()
    {

//        $this->request->setMethod('get');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result->msg);
//            echo "\n--------------------------------------------------------\n";
//        } else {
////            print_r($result);
//        }
//        //print_r($s);
//        $this->assertEquals(1, $s);
    }

    public function testDelete()
    {
//        //create one to delete first
//        $em = $this->controller->getEntityManager();
//
//        $sample = new \Core\Entity\ModuleType($em);
//        $sample->hydrate(['name' => 'PHPUNIT']);
//
//        if (!$sample->validate()) {
//            throw new Exception(Json::encode($sample->getMessages(), true));
//        }
//
//        $em->persist($sample);
//        $em->flush($sample);
//
//        $this->routeMatch->setParam('id', $sample->getId());
//        $this->request->setMethod('delete');
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result);
//            echo "\n--------------------------------------------------------\n";
//        } else {
////            print_r($result);
//        }
//        $this->assertEquals(1, $s);
    }

}

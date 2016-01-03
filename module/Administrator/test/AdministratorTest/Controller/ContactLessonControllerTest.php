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
        
        
        $result = $this->controller->dispatch($this->request);
        $this->PrintOut($result, true);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);
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

    public function testUpdate()
    {
//        $this->routeMatch->setParam('id', '1');
//        $this->request->setMethod('put');
//
//        $this->request->setContent(http_build_query([
//            "name" => "Ahoi Tere"
//        ]));
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $s = (int) $result->success;
//        if ($s !== 1) {
//            echo "\n--------------------------------------------------------\n";
//            print_r($result);
//            echo "\n--------------------------------------------------------\n";
//        } else {
//            //print_r($result);
//        }
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

<?php

/**
 * LIS development
 * Rest API ControllerTests
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\GradeChoiceController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * REST API ControllerTests
 * 
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
class GradeChoiceControllerTest extends UnitHelpers {

    //put your code here
    // protected function setUp(){
    // }
    //public function testDummyTest(){
    //$a=0;
    // $this->assertEquals(1,$a);
    //}
    protected function setUp() {
        $this->controller = new GradeChoiceController();
        parent::setUp();
    }
//
//    /**
//     * imitate POST request
//     * create new with correct data see entity
//     */
//    public function testCreate() {
//        $name = 'name' . uniqid();
//        $this->request->setMethod('post');
//        //$gradeChoice = $this->CreateGradeChoice();
//        $this->request->getPost()->set('name', $name);
//        //$this->request->getPost()->set('gradeChoice', $gradeChoice->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//
//        $this->PrintOut($result, true);
//    }
//
//    public function testCreateWithCreatedByAndUpdatedBy() {
//        $this->request->setMethod('post');
//        $name = uniqid() . 'name';
//        $this->request->getPost()->set('name', $name);
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
//        $this->PrintOut($result, false);
//
//        $repository = $this->em->getRepository('Core\Entity\GradeChoice');
//        $newGradeChoice = $repository->find($result->data['id']);
//        $this->assertEquals($lisUserCreatesId, $newGradeChoice->getCreatedBy()->getId());
//        $this->assertEquals($lisUserUpdatesId, $newGradeChoice->getUpdatedBy()->getId());
//    }
//
//    public function testCreateNoData() {
//        $this->request->setMethod('post');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, FALSE);
//    }

    /**
     * create one before asking list
     */
    public function testGetList() {
        //die("What is wrong?");
       //$this->CreateGradeChoice();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, FALSE);
    }

    /**
     * create one before getting
     */
    public function testGet() {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateGradeChoice()->getId());
        //$myevilhack = $this->CreateAbsenceReason()->getId().'; DROP database lis;'
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, FALSE);
    }

    public function testUpdate() {
        //create one to update later
        $gradeChoice = $this->CreateGradeChoice();
        $id = $gradeChoice->getId();
        $nameOld = $gradeChoice->getName();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        //set new data
        //$nameU = uniqid() . 'new name';
        //set new data
        $this->request->setContent(http_build_query([
            'name' => uniqid() . 'GradeChoiceName',
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //print_r($result->data['name']);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\GradeChoice')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $nameOld, $r->getName()
        );
        $this->PrintOut($result, FALSE);
    }

    public function testDelete() {
        $gradeChoice = $this->CreateGradeChoice();
        $idOld = $gradeChoice->getId();
        $this->routeMatch->setParam('id', $gradeChoice->getId());
        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();
        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\GradeChoice')
                ->Get($idOld);
        $this->assertEquals(null, $deleted);
        $this->PrintOut($result, FALSE);
    }

//    public function testCreatedWithCreatedAtAndUpdatedAt() {
//        $this->request->setMethod('post');
//
//        $name = uniqid() . 'name';
//        $this->request->getPost()->set('name', $name);
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, false);
//
//        $repository = $this->em->getRepository('Core\Entity\GradeChoice');
//        $newGradeChoice = $repository->find($result->data['id']);
//        $this->assertNotNull($newGradeChoice->getCreatedAt());
//        $this->assertNotNull($newGradeChoice->getUpdatedAt());
//    }
//
}

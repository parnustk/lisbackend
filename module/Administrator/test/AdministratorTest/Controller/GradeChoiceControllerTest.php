<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\GradeChoiceController;



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

    /**
     * imitate POST request
     */
    public function testCreate() {
        $name = 'GradeChoice' . uniqid();
        $this->request->setMethod('post');
        //$this->request->getPost()->set("name", "TEST");
        // $this->request->getPost()->set("Parnu", "Linn");*/
       // $vocation = $this->CreateGradeChoice();
        $this->request->getPost()->set('name', $name);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);
        
    }

//    public function testCreateNoData() {
//        $this->request->setMethod('post');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertNotEquals(1, $result->success);
//        $this->PrintOut($result, FALSE);
//    }
//
//    /**
//     * create one before asking list
//     */
//    public function testGetList() {
//        $this->CreateGradeChoice();
//        $this->request->setMethod('get');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->assertGreaterThan(0, count($result->data));
//        $this->PrintOut($result, FALSE);
//    }
//
//    /**
//     * create one before getting
//     */
//    public function testGet() {
//        $this->request->setMethod('get');
//        $this->routeMatch->setParam('id', $this->CreateGradeChoice()->getId());
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->PrintOut($result, FALSE);
//    }
//
//    public function testUpdate() {
//        //create one to update later
//        $entity = $this->CreateGradeChoice();
//        $id = $entity->getId();
//        $nameOld = $entity->getName();
//        //prepare request
//        $this->routeMatch->setParam('id', $id);
//        $this->request->setMethod('put');
//        $this->request->setContent(http_build_query([
//            'name' => 'Updated StudentGradeChoice' . uniqid(),
//        ]));
//        //fire request
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        //set new data
//        $r = $this->em
//                ->getRepository('Core\Entity\GradeChoice')
//                ->find($result->data['id']);
//        $this->assertNotEquals(
//                $nameOld, $r->getName()
//        );
//        $this->PrintOut($result, FALSE);
//    }
//
//    public function testDelete() {
//           $entity = $this->CreateGradeChoice();
//        $idOld = $entity->getId();
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
//        //test it is not in the database anymore
//        $deleted = $this->em
//                ->getRepository('Core\Entity\GradeChoice')
//                ->Get($idOld);
//
//        $this->assertEquals(null, $deleted);
//
//        $this->PrintOut($result, false);
//    }
    public function testCreateWithCreateBy() {
        $name = 'GradeChoice' . uniqid();
        $this->request->setMethod('post');
        //$this->request->getPost()->set("name", "TEST");
        // $this->request->getPost()->set("Parnu", "Linn");*/
       // $vocation = $this->CreateGradeChoice();
        $this->request->getPost()->set('name', $name);
        //
        $lisUser=$this->CreateLisUser();
        $this->request->getPost()->set("lisUser",$lisUser->getId());
        //
        $lisUserCreates=$this->CreateLisUser();
        $lisUserUpdatesId=$lisUserCreates->getId();
        $this->request->getPost()->set("createdBy",$lisUserCreatesId);
        
        $lisUserCreates=$this->CreateLisUser();
        $lisUserUpdatesId=$lisUserUpdates->getId();
        $this->request->getPost()->set("createdBy",$lisUpdatesId);
        //
        $lisUserUpdates=$this->CreateLisUser();
        $lisUserUpdateId=$lisUserUpdates->getId();
        $this->requestgetPost()->set("updatedBy",$lisUserUpdatesId);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, true);
        
        $repository=$this->em->getRepository('Core\Entity\Administrator');
        $newAdministrator=$repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId,$newAdministrator->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId,$newAdministrator->getUpdatedBy()->getId());
        
    }

}

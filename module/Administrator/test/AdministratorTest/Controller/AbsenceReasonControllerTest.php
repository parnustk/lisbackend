<?php

/**
 * Description of AbsenceReasonControllerTest
 *
 * @author eleri
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceReasonController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class AbsenceReasonControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new AbsenceReasonController();
        parent::setUp();
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     */
    public function testCreate()
    {
        $name = 'AbsenceReason name'.uniqid();
        $this->request->setMethod('post');

        $this->request->getPost()->set('name', $name);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);
    }
    
    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAbsenceReason()->getId());
        //$myevilhack = $this->CreateAbsenceReason()->getId().'; DROP database lis;'
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    public function testUpdate()
    {
        //create one to  update later on
        $absenceReason = $this->CreateAbsenceReason();
        $nameOld= $absenceReason->getName();
        
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absenceReason->getId());
        
        //set new data
        $nameU = uniqid() . 'new name';
        //set new data
        $this->request->setContent(http_build_query([
            "name" => $nameU,
        ]));
  
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, true);
        print_r($result->data['name']);
        
        $this->assertNotEquals($nameOld, $result->data['name']);
        
    }
    
    public function testDelete()
    {
        $absenceReasonRepository = $this->em->getRepository('Core\Entity\AbsenceReason');
        
        //create one to delete later on
        $entity = $this->CreateAbsenceReason();
        $idOld = $entity->getId();

        $this->assertNull($absenceReasonRepository->find($idOld)->getTrashed());
        
        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, false);
        
        
        
        $this->assertNotNull($absenceReasonRepository->find($idOld)->getTrashed());
    }


//
//    /**
//     * create one before asking list
//     */
//    public function testGetList()
//    {
//        $this->CreateAbsenceReason();
//        $this->request->setMethod('get');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        $this->assertGreaterThan(0, count($result->data));
//        $this->PrintOut($result, FALSE);
//    }
//

//
//    public function testDelete()
//    {
//        $entity = $this->CreateAbsenceReason();
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
//                ->getRepository('Core\Entity\AbsenceReason')
//                ->Get($idOld);
//
//        $this->assertEquals(null, $deleted);
//
//        $this->PrintOut($result, false);
//    }

}

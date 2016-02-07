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
class GradeChoiceControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new GradeChoiceController();
        parent::setUp();
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     */
    public function testCreate()
    {
        $name = 'name' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('name', $name);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateWithCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');
        $name = uniqid() . 'name';
        $this->request->getPost()->set('name', $name);

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);

        $repository = $this->em->getRepository('Core\Entity\GradeChoice');
        $newGradeChoice = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newGradeChoice->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newGradeChoice->getUpdatedBy()->getId());
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    /**
     * create one before asking list
     */
    public function testGetList()
    {
        //die("What is wrong?");
        $this->CreateGradeChoice();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * create one before getting
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateGradeChoice()->getId());
        //$myevilhack = $this->CreateAbsenceReason()->getId().'; DROP database lis;'
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testUpdate()
    {
        //create one to update later
        $gradeChoice = $this->CreateGradeChoice();
        $id = $gradeChoice->getId();
        $nameOld = $gradeChoice->getName();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        //set new data
        $this->request->setMethod('put');
        //$nameU = uniqid() . 'new name';
        //set new data
        $this->request->setContent(http_build_query([
            'name' => uniqid() . 'GradeChoiceName',
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
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
    }

    public function testDelete()
    {
        $entity = $this->CreateGradeChoice();
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

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\GradeChoice')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);
    }

    public function testCreatedWithCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');

        $name = uniqid() . 'name';
        $this->request->getPost()->set('name', $name);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);

        $repository = $this->em->getRepository('Core\Entity\GradeChoice');
        $newGradeChoice = $repository->find($result->data['id']);
        $this->assertNotNull($newGradeChoice->getCreatedAt());
        $this->assertNull($newGradeChoice->getUpdatedAt());
    }

}

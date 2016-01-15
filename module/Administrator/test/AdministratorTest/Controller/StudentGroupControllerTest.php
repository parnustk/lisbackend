<?php

/*
 * 
 * LIS development
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2016 Lis dev team
 * @license    TODO
 * 
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\StudentGroupController;

class StudentGroupControllerTest extends UnitHelpers
{

    /**
     * @author Kristen <seppkristen@gmail.com>
     */
    protected function setUp()
    {
        $this->controller = new StudentGroupController();
        parent::setUp();
    }

    /**
     * Imitate POST request
     */
    public function testCreate()
    {
        $name = 'StudentGroupName' . uniqid();
        $this->request->setMethod('post');
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('vocation', $vocation->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, FALSE);
    }

    public function testCreateWithCreatedByAndUpdatedBy()
    {
        $name = 'StudentGroupName' . uniqid();
        $this->request->setMethod('post');
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('vocation', $vocation->getId());

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

        $repository = $this->em->getRepository('Core\Entity\StudentGroup');
        $newStudentGroup = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newStudentGroup->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newStudentGroup->getUpdatedBy()->getId());
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);

        $this->PrintOut($result, FALSE);
    }

    /**
     * create one before asking list
     */
    public function testGetList()
    {
        $this->CreateStudentGroup();
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
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateStudentGroup()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, FALSE);
    }

    public function testUpdate()
    {
        //create one to update later
        $entity = $this->CreateStudentGroup();
        $id = $entity->getId();
        $nameOld = $entity->getName();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'name' => 'Updated StudentGroupName' . uniqid(),
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\StudentGroup')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $nameOld, $r->getName()
        );
        $this->PrintOut($result, FALSE);
    }

    public function testDelete()
    {
        $entity = $this->CreateStudentGroup();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\StudentGroup')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, FALSE);
    }

    public function testCreatedAtAndUpdatedAt()
    {
        $name = 'StudentGroupName' . uniqid();
        $this->request->setMethod('post');
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('vocation', $vocation->getId());

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

        $repository = $this->em->getRepository('Core\Entity\StudentGroup');
        $newStudentGroup = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newStudentGroup->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newStudentGroup->getUpdatedBy()->getId());
    }
    
    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateStudentGroup();
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'trashed' => 1,
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\StudentGroup')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
        $this->PrintOut($result, FALSE);
    }

}

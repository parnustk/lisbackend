<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\RoomController;

/**
 * @author Alar Aasa
 */
class RoomControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new RoomController();
        parent::setUp();
    }

    /*
     * Tests create without any data
     */

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    /**
     * Test create with data
     */
    public function testCreate()
    {
        $name = 'Classroom name' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('name', $name);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * testing GET
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateRoom()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST rows get read
     */
    public function testGetList()
    {
        $this->CreateRoom();
        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * TEST row gets updated by id
     */
    public function testUpdate()
    {
        $entity = $this->CreateRoom();
        $id = $entity->getId();

        $nameOld = $entity->getName();

        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'name' => uniqid() . 'room',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Rooms')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $nameOld, $r->getName()
        );
    }

    public function testDelete()
    {
        $entity = $this->CreateRoom();
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
                ->getRepository('Core\Entity\Rooms')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }

    public function testCreateWithCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $roomName = uniqid() . 'roomname';
        $this->request->getPost()->set('name', $roomName);

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);


        $repository = $this->em->getRepository('Core\Entity\Rooms');
        $newRoom = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newRoom->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newRoom->getUpdatedBy()->getId());
    }

    public function testCreatedWithCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');

        $roomName = uniqid() . 'roomname';
        $this->request->getPost()->set('name', $roomName);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);


        $repository = $this->em->getRepository('Core\Entity\Rooms');
        $newRoom = $repository->find($result->data['id']);
        $this->assertNotNull($newRoom->getCreatedAt());
        $this->assertNull($newRoom->getUpdatedAt());
    }

    public function testGetListWithPagination()
    {
        $this->request->setMethod('get');

        $this->CreateRoom();
        $this->CreateRoom();

        $q = 'page=1&limit=1';
        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
    }

}

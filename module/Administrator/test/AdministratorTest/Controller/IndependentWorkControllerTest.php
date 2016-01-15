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

use Administrator\Controller\IndependentWorkController;

class IndependentWorkControllerTest extends UnitHelpers
{

    /**
     * @author Kristen <seppkristen@gmail.com>
     */
    protected function setUp()
    {
        $this->controller = new IndependentWorkController();
        parent::setUp();
    }

    /**
     * Imitate POST request
     */
    public function testCreate()
    {
        $durationAK = 5;
        $description = uniqid() . ' Unique description';
        $duedate = new \DateTime;
        $teacher = $this->CreateTeacher();
        $subjectRound = $this->CreateSubjectRound();

        $this->request->setMethod('post');

        $this->request->getPost()->set('subjectRound', $subjectRound->getId());
        $this->request->getPost()->set('teacher', $teacher->getId());
        $this->request->getPost()->set('duedate', $duedate);
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('durationAK', $durationAK);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateWithCreatedByAndUpdatedBy()
    {
        $durationAK = 5;
        $description = uniqid() . ' Unique description';
        $duedate = new \DateTime;
        $teacher = $this->CreateTeacher();
        $subjectRound = $this->CreateSubjectRound();

        $this->request->setMethod('post');

        $this->request->getPost()->set('subjectRound', $subjectRound->getId());
        $this->request->getPost()->set('teacher', $teacher->getId());
        $this->request->getPost()->set('duedate', $duedate);
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('durationAK', $durationAK);

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $repository = $this->em->getRepository('Core\Entity\IndependentWork');
        $newStudentGroup = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newStudentGroup->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newStudentGroup->getUpdatedBy()->getId());
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
        $this->CreateIndependentWork();
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
        $this->routeMatch->setParam('id', $this->CreateIndependentWork()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testUpdate()
    {
        //create one to update later
        $entity = $this->CreateIndependentWork();
        $id = $entity->getId();
        $descriptionOld = $entity->getDescription();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'description' => 'Updated IndependentWork description' . uniqid(),
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\IndependentWork')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $descriptionOld, $r->getDescription()
        );
    }

    public function testDelete()
    {
        $entity = $this->CreateIndependentWork();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\IndependentWork')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);
    }

    public function testCreatedAtAndUpdatedAt()
    {
        $durationAK = 5;
        $description = uniqid() . ' Unique description';
        $duedate = new \DateTime;
        $teacher = $this->CreateTeacher();
        $subjectRound = $this->CreateSubjectRound();

        $this->request->setMethod('post');

        $this->request->getPost()->set('subjectRound', $subjectRound->getId());
        $this->request->getPost()->set('teacher', $teacher->getId());
        $this->request->getPost()->set('duedate', $duedate);
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('durationAK', $durationAK);

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $repository = $this->em->getRepository('Core\Entity\IndependentWork');
        $newStudentGroup = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newStudentGroup->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newStudentGroup->getUpdatedBy()->getId());
    }

    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateIndependentWork();
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
        $this->PrintOut($result, FALSE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\IndependentWork')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
    }

}

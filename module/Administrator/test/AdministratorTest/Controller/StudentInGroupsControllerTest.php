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

use Administrator\Controller\StudentInGroupsController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class StudentInGroupsControllerTest extends UnitHelpers
{

    /**
     * @author Kristen <seppkristen@gmail.com>
     */
    protected function setUp()
    {
        $this->controller = new StudentInGroupsController();
        parent::setUp();
    }

    /**
     * Should be successful
     * 
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreate()
    {
        $status = uniqid();
        $this->request->setMethod('post');

        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('studentGroup', $this->CreateStudentGroup()->getId());
        $this->request->getPost()->set('status', $status);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoStatus()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('studentGroup', $this->CreateStudentGroup()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoStudent()
    {
        $status = uniqid();
        $this->request->setMethod('post');

        $this->request->getPost()->set('studentGroup', $this->CreateStudentGroup()->getId());
        $this->request->getPost()->set('status', $status);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoStudentGroup()
    {
        $status = uniqid();
        $this->request->setMethod('post');

        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('status', $status);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateStudentInGroups()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testGetList()
    {
        $this->CreateStudentInGroups();

        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    public function testUpdate()
    {
        //create one to  update later on
        $studentInGroups = $this->CreateStudentInGroups();
        $studentIdOld = $studentInGroups->getStudent()->getId();
        $studentGroupIdOld = $studentInGroups->getStudentGroup()->getId();

        $this->PrintOut($studentIdOld, FALSE);
        $this->PrintOut($studentGroupIdOld, FALSE);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $studentInGroups->getId());

        $this->request->setContent(http_build_query([
            'student' => $this->CreateStudent()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, FALSE);

        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($studentGroupIdOld, $result->data['studentGroup']['id']);
    }

    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateStudentInGroups();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\StudentInGroups')
                ->find($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {

        $entity = $this->CreateStudentInGroups();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\StudentInGroups')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }

    public function testCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $status = uniqid();
        $studentGroup = $this->CreateStudentGroup()->getId();
        $student = $this->CreateStudent()->getId();

        $this->request->getPost()->set('status', $status);
        $this->request->getPost()->set('student', $student);
        $this->request->getPost()->set('studentGroup', $studentGroup);

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

        $repository = $this->em->getRepository('Core\Entity\StudentInGroups');
        $newStudentInGroups = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newStudentInGroups->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newStudentInGroups->getUpdatedBy()->getId());
    }
    
    public function testCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');

        $status = uniqid();
        $studentInGroups = $this->CreateStudentInGroups()->getId();
        $studentGroup = $this->CreateStudentGroup()->getId();
        $student = $this->CreateStudent()->getId();
        
        $this->request->getPost()->set('status', $status);
        $this->request->getPost()->set('student', $student);
        $this->request->getPost()->set('studentInGroups', $studentInGroups);
        $this->request->getPost()->set('studentGroup', $studentGroup);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        

        $repository = $this->em->getRepository('Core\Entity\StudentInGroups');
        $newGt = $repository->find($result->data['id']);
        $this->assertNotNull($newGt->getCreatedAt());
        $this->assertNull($newGt->getUpdatedAt());
    }

    /**
     * TEST rows get read by limit and page params
     */
    public function testGetListWithPaginaton()
    {
        $this->request->setMethod('get');

        //set record limit to 1
        $q = 'page=1&limit=1'; //imitate real param format
        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
    }
    
    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateStudentInGroups();
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
                ->getRepository('Core\Entity\StudentInGroups')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
    }
    
    public function testGetTrashedList()
    {
        //prepare one StudentInGroups with trashed flag set up
        $entity = $this->CreateStudentInGroups();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $entity->getId()
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //limit is set to 1
        $this->assertEquals(1, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }
}

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceReasonController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
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
        $name = 'AbsenceReason name' . uniqid();
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

    /**
     * create one before asking list
     */
    public function testGetList()
    {
        $this->CreateAbsenceReason();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    /**
     * create one before getting
     */
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
        $id = $absenceReason->getId();
        $nameOld = $absenceReason->getName();

        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

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

        $this->PrintOut($result, false);
        //print_r($result->data['name']);

        $this->assertNotEquals($nameOld, $result->data['name']);
    }

    /**
     * TEST row gets deleted by id
     * can only try to delete smt what is trashed
     */
    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateAbsenceReason();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\AbsenceReason')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {

        $entity = $this->CreateAbsenceReason();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\AbsenceReason')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }

    public function testCreatedAtAndUpdatedBy()
    {
        $name = 'AbsenceReasonName' . uniqid();
        $this->request->setMethod('post');
        $absencereason = $this->CreateAbsenceReason();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('absencereason', $absencereason->getId());

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

        $repository = $this->em->getRepository('Core\Entity\AbsenceReason');
        $newAbsenceReason = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newAbsenceReason->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newAbsenceReason->getUpdatedBy()->getId());
    }
    
    public function testCreatedByAndUpdatedAt()
    {
        $this->request->setMethod('post');
        
        $name = 'AbsenceReasonName' . uniqid();
        $this->request->setMethod('post');
        $absencereason = $this->CreateAbsenceReason();
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('absencereason', $absencereason->getId());

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $repository = $this->em->getRepository('Core\Entity\AbsenceReason');
        $newAbsenceReason = $repository->find($result->data['id']);
        $this->assertNotNull($newAbsenceReason->getCreatedAt());
        $this->assertNull($newAbsenceReason->getUpdatedAt());
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
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testGetTrashedList()
    {

        //prepare one AbsenceReason with trashed flag set up
        $entity = $this->CreateAbsenceReason();
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

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //limit is set to 1
        $this->assertEquals(1, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }
    
    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateAbsenceReason();
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'trashed' => 1,
            'id' => $id
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $repository = $this->em
                ->getRepository('Core\Entity\AbsenceReason')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $repository->getTrashed()
        );
    }

}

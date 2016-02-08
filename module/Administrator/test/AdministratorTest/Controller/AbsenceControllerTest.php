<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new AbsenceController();
        parent::setUp();
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, (bool) $result->success);
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     */
    public function testCreate()
    {
        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateWithAbsenceReason()
    {
        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());
        $this->request->getPost()->set('absenceReason', $this->CreateAbsenceReason()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST row gets not created
     */
    public function testCreateNoDescription()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testCreateNoStudent()
    {
        $this->request->setMethod('post');
        $description = 'Absence description' . uniqid();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testCreateNoContactLesson()
    {
        $this->request->setMethod('post');
        $description = 'Absence description' . uniqid();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateAbsence()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testGetList()
    {
        $this->CreateAbsence();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    public function testUpdate()
    {
        //create one to  update later on
        $absence = $this->CreateAbsence();
        $studentIdOld = $absence->getStudent()->getId();
        $contactLessonIdOld = $absence->getContactLesson()->getId();
        $absenceReasonIdOld = $absence->getAbsenceReason()->getId();
        $this->PrintOut($studentIdOld, false);
        $this->PrintOut($contactLessonIdOld, false);
        $this->PrintOut($absenceReasonIdOld, false);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);

        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
        $this->assertNotEquals($absenceReasonIdOld, $result->data['absenceReason']['id']);
    }

    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateAbsence();
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
                ->getRepository('Core\Entity\Absence')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {

        $entity = $this->CreateAbsence();
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
                ->getRepository('Core\Entity\Absence')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }

    public function testCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $description = 'Absence description' . uniqid();
        $absence = $this->CreateAbsence()->getId();
        $student = $this->CreateStudent()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();
        $absenceReason = $this->CreateAbsenceReason()->getId();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $student);
        $this->request->getPost()->set('absence', $absence);
        $this->request->getPost()->set('absenceReason', $absenceReason);
        $this->request->getPost()->set('contactLesson', $contactLesson);

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

        

        $repository = $this->em->getRepository('Core\Entity\Absence');
        $newAbsence = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newAbsence->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newAbsence->getUpdatedBy()->getId());
    }
    
    public function testCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');

        $description = 'Absence description' . uniqid();
        $absence = $this->CreateAbsence()->getId();
        $student = $this->CreateStudent()->getId();
        $contactLesson = $this->CreateContactLesson()->getId();
        $absenceReason = $this->CreateAbsenceReason()->getId();
        
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $student);
        $this->request->getPost()->set('absence', $absence);
        $this->request->getPost()->set('absenceReason', $absenceReason);
        $this->request->getPost()->set('contactLesson', $contactLesson);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        

        $repository = $this->em->getRepository('Core\Entity\Absence');
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
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
        
    }
    
    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateAbsence();
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
                ->getRepository('Core\Entity\Absence')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
    }

    public function testGetTrashedList()
    {

        //prepare one AbsenceReason with trashed flag set up
        $entity = $this->CreateAbsence();
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

}

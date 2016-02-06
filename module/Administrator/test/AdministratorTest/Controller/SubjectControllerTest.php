<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectController();
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

    public function testCreate()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("durationAllAK", "30");
        $this->request->getPost()->set("durationContactAK", "10");
        $this->request->getPost()->set("durationIndependentAK", "20");

        $this->request->getPost()->set("module", $this->CreateModule()->getId());

        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateNoGradingType()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("durationAllAK", "30");
        $this->request->getPost()->set("durationContactAK", "10");
        $this->request->getPost()->set("durationIndependentAK", "20");

        $this->request->getPost()->set("module", $this->CreateModule()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
        $this->PrintOut($result, false);
    }

    public function testCreateNoModule()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("durationAllAK", "30");
        $this->request->getPost()->set("durationContactAK", "10");
        $this->request->getPost()->set("durationIndependentAK", "20");

        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateSubject()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        //create one to get first
        $this->CreateSubject();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testUpdate()
    {
        $created = $this->CreateSubject();

        $codeOld = $created->getCode();
        $nameOld = $created->getName();
        $durationAllAKOld = $created->getDurationAllAK();
        $durationContactAKOld = $created->getDurationContactAK();
        $durationIndependentAKOld = $created->getDurationIndependentAK();
        $moduleIdOld = $created->getModule()->getId();

        $gradingTypesOld = [];
        foreach ($created->getGradingType() as $gType) {
            $gradingTypesOld[] = $gType->getId();
        }

        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $created->getId());
        
        $this->request->setContent(http_build_query([
            'code' => 'code',
            'name' => 'Updated',
            'durationAllAK' => 1000,
            'durationContactAK' => 600,
            'durationIndependentAK' => 400,
            'module' => $this->CreateModule()->getId(),
            'gradingType' => [
                ['id' => $this->CreateGradingType()->getId()],
                ['id' => $this->CreateGradingType()->getId()]
            ],
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Subject')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $nameOld, $r->getName()
        );

        $this->assertNotEquals(
                $codeOld, $r->getCode()
        );

        $this->assertNotEquals(
                $durationAllAKOld, $r->getDurationAllAK()
        );

        $this->assertNotEquals(
                $durationContactAKOld, $r->getDurationContactAK()
        );
        $this->assertNotEquals(
                $durationIndependentAKOld, $r->getDurationIndependentAK()
        );

        $this->assertNotEquals(
                $moduleIdOld, $r->getModule()->getId()
        );
        //test that gradeTypes have beeing updated
        foreach ($r->getGradingType() as $gtU) {
            $this->assertEquals(
                    false, in_array($gtU->getId(), $gradingTypesOld)
            );
        }
        $this->PrintOut($result, false);
    }

    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateSubject();
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
                ->getRepository('Core\Entity\Subject')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {

        $entity = $this->CreateSubject();
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
                ->getRepository('Core\Entity\Subject')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);

        $this->PrintOut($result, false);
    }
    
    public function testGetTrashedList()
    {

//        prepare one Subject with trashed flag set up
        $entity = $this->CreateSubject();
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
    
     public function testCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $code = 'ContactLesson code' . uniqid();
        $name = 'ContactLesson name' . uniqid();
        $durationAllAK = 100;
        $durationContactAK = 60;
        $durationIndependentAK = 40;
        
//        $this->request->getPost()->set("module", $this->CreateModule()->getId());
//
//        $this->request->getPost()->set("gradingType", [
//            ['id' => $this->CreateGradingType()->getId()],
//            ['id' => $this->CreateGradingType()->getId()],
//        ]);
        $module = $this->CreateModule()->getId();
        $gradingType = [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ];

        $subject = $this->CreateSubject()->getId();

        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('durationAllAK', $durationAllAK);
        $this->request->getPost()->set('durationContactAK', $durationContactAK);
        $this->request->getPost()->set('durationIndependentAK', $durationIndependentAK);
        $this->request->getPost()->set("module", $module);
        $this->request->getPost()->set("gradingType", $gradingType);

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

        $repository = $this->em->getRepository('Core\Entity\Subject');
        $newSubject = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newSubject->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newSubject->getUpdatedBy()->getId());
    }
}

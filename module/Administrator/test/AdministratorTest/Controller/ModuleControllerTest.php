<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\ModuleController;
use Zend\Json\Json;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>, Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new ModuleController();
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
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateNoGradingType()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
    }

    public function testCreateNoVocation()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
    }

    public function testCreateNoModuleType()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateModule()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        //create one to get first
        $this->CreateModule();
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
        $createdModule = $this->CreateModule();

        $nameOld = $createdModule->getName();
        $codeOld = $createdModule->getCode();
        $durationOld = $createdModule->getDuration();

        $vocationIdOld = $createdModule->getVocation()->getId();
        $moduleTypeOld = $createdModule->getModuleType()->getId();

        $gradingTypesOld = [];
        foreach ($createdModule->getGradingType() as $gType) {
            $gradingTypesOld[] = $gType->getId();
        }

        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $createdModule->getId());

        $this->request->setContent(http_build_query([
            "name" => "Updated",
            'code' => uniqid(),
            'duration' => 888,
            'vocation' => $this->CreateVocation()->getId(),
            'moduleType' => $this->CreateModuleType()->getId(),
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

        $resultModule = $this->em
                ->getRepository('Core\Entity\Module')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $nameOld, $resultModule->getName()
        );

        $this->assertNotEquals(
                $codeOld, $resultModule->getCode()
        );

        $this->assertNotEquals(
                $durationOld, $resultModule->getDuration()
        );

        $this->assertNotEquals(
                $vocationIdOld, $resultModule->getVocation()->getId()
        );
        $this->assertNotEquals(
                $moduleTypeOld, $resultModule->getModuleType()->getId()
        );
        //test that gradeTypes have beeing updated
        foreach ($resultModule->getGradingType() as $gtU) {
            $this->assertEquals(
                    false, in_array($gtU->getId(), $gradingTypesOld)
            );
        }
        $this->PrintOut($result, false);
    }

    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateModule();
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
                ->getRepository('Core\Entity\Module')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }
    
    public function testDelete()
    {

        $entity = $this->CreateModule();
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

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Module')
                ->Get($idOld);

        $this->assertEquals(null, $deleted);
    }
    
    public function testCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');
        
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("code", uniqid());

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

        $repository = $this->em->getRepository('Core\Entity\Module');
        $newModule = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newModule->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newModule->getUpdatedBy()->getId());
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
    
    public function testGetTrashedList()
    {

        //prepare one Module with trashed flag set up
        $entity = $this->CreateModule();
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

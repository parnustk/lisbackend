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
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class ModuleControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new ModuleController();
        parent::setUp();
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoData()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, (bool) $result->success);

        //test that message contains Missing vocation for module
        $validator = new Regex(['pattern' => '/Missing vocation/U']); //U - non greedy
        $this->assertTrue($validator->isValid($result->message));
    }

    /**
     * Imitate POST request
     * Should be successful
     */
    public function testCreate()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("moduleCode", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoGradingType()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("moduleCode", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);

        //test that message contains No result was found
        $validator = new Regex(['pattern' => '/No result was found/U']);
        $this->assertFalse($validator->isValid($result->message));
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoVocation()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("moduleCode", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);

        //test that message contains Missing vocation for module
        $validator = new Regex(['pattern' => '/Missing vocation/U']);
        $this->assertTrue($validator->isValid($result->message));
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoModuleType()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("moduleCode", uniqid());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);

        //test that message contains moduleType":{"isEmpty
        $validator = new Regex(['pattern' => '/moduleType.{4}isEmpty/U']);
        $this->assertTrue($validator->isValid($result->message));
    }

    /**
     * Should be successful
     */
    public function testGet()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateModule()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    /**
     * Should be successful
     */
    public function testGetList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

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

    /**
     * Should be successful
     */
    public function testUpdate()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $createdModule = $this->CreateModule();

        $nameOld = $createdModule->getName();
        $codeOld = $createdModule->getModuleCode();
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
            'moduleCode' => uniqid(),
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
                $codeOld, $resultModule->getModuleCode()
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

    /**
     * Should be NOT successful
     */
    public function testDeleteNotTrashed()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

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

    /**
     * Should be successful
     */
    public function testDelete()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

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
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }

    /**
     * Should be successful
     */
    public function testCreatedAtAndUpdatedAt()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $this->request->getPost()->set("vocation", $this->CreateVocation()->getId());
        $this->request->getPost()->set("moduleType", $this->CreateModuleType()->getId());
        $this->request->getPost()->set("gradingType", [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ]);
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("duration", "30");
        $this->request->getPost()->set("moduleCode", uniqid());

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $repository = $this->em->getRepository('Core\Entity\Module');
        $newModule = $repository->find($result->data['id']);
        $this->assertNotNull($newModule->getCreatedAt());
        $this->assertNull($newModule->getUpdatedAt());
    }

    /**
     * TEST rows get read by limit and page params
     * Should be successful
     */
    public function testGetListWithPaginaton()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

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

    /**
     * Should be successful
     */
    public function testGetTrashedList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

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

    /**
     * Should be successful
     */
    public function testTrashed()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to update later
        $entity = $this->CreateModule();
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'trashed' => 1,
            'vocation' => $entity->getVocation()->getId()
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $repository = $this->em
                ->getRepository('Core\Entity\Module')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $repository->getTrashed()
        );
    }

}

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
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectController();
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

        //test that message contains isEmpty
        $validator = new Regex(['pattern' => '/isEmpty/U']); //U - non greedy
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

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("name", "Test Tere Maailm");
        $this->request->getPost()->set("durationAllAK", "30");
        $this->request->getPost()->set("durationContactAK", "10");
        $this->request->getPost()->set("durationIndependentAK", "20");

        $this->request->getPost()->set("module", $this->CreateModule()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $result->success);

        //test that message contains No result was found
        $validator = new Regex(['pattern' => '/No result was found/U']);
        $this->assertTrue($validator->isValid($result->message));
    }

    public function testCreateNoModule()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

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
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);

        //test that message contains module":{"isEmpty
        $validator = new Regex(['pattern' => '/module.{4}isEmpty/U']);
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
        $this->routeMatch->setParam('id', $this->CreateSubject()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
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
        $this->CreateSubject();
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

        $entity = $this->CreateSubject();
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
                ->getRepository('Core\Entity\Subject')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
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
        $entity = $this->CreateSubject();
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'trashed' => 1,
            'id' => $id,
            'module' => $entity->getModule()->getId()
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $repository = $this->em
                ->getRepository('Core\Entity\Subject')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $repository->getTrashed()
        );
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

    public function testCreatedAtAndUpdatedAt()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $code = 'Subject code' . uniqid();
        $name = 'Subject name' . uniqid();
        $durationAllAK = 100;
        $durationContactAK = 60;
        $durationIndependentAK = 40;
        $module = $this->CreateModule()->getId();
        $gradingType = [
            ['id' => $this->CreateGradingType()->getId()],
            ['id' => $this->CreateGradingType()->getId()],
        ];
        $this->request->getPost()->set('code', $code);
        $this->request->getPost()->set('name', $name);
        $this->request->getPost()->set('durationAllAK', $durationAllAK);
        $this->request->getPost()->set('durationContactAK', $durationContactAK);
        $this->request->getPost()->set('durationIndependentAK', $durationIndependentAK);
        $this->request->getPost()->set("module", $module);
        $this->request->getPost()->set("gradingType", $gradingType);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $repository = $this->em->getRepository('Core\Entity\Subject');
        $newSubject = $repository->find($result->data['id']);
        $this->assertNotNull($newSubject->getCreatedAt());
        $this->assertNull($newSubject->getUpdatedAt());
    }

}

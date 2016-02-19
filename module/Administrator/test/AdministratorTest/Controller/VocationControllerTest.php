<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\VocationController;
use Zend\Json\Json;

/**
 * @author Juhan Kõks <juhankoks@gmail.com> , Sander Mets <sandermets0@gmail.com>
 */
class VocationControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new VocationController();
        parent::setUp();
    }

    /**
     * TEST row gets created
     */
    public function testCreate()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("name", "Name vocation");
        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("durationEKAP", 120);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST row gets not created
     */
    public function testCreateNoName()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("code", uniqid());
        $this->request->getPost()->set("durationEKAP", 120);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    /**
     * TEST row gets not created
     */
    public function testCreateNoCode()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("name", "Name vocation");
        $this->request->getPost()->set("durationEKAP", 120);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    /**
     * TEST row gets not created
     */
    public function testCreateNodurationEKAP()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set("name", "Name vocation");
        $this->request->getPost()->set("code", uniqid());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

    /**
     * TEST row gets not created
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
     * TEST row gets read by id
     */
    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateVocation()->getId());
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
        $this->CreateVocation();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $this->PrintOut($result, false);

        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * TEST row gets updated by id
     */
    public function testUpdate()
    {
        //create vocation
        $entity = $this->CreateVocation();
        $id = $entity->getId();

        $nameOld = $entity->getName();
        $codeOld = $entity->getCode();
        $durationEKAPOld = $entity->getDurationEKAP();

        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'name' => 'Updated',
            'code' => uniqid(),
            'durationEKAP' => '456',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Vocation')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $nameOld, $r->getName()
        );
        $this->assertNotEquals(
                $codeOld, $r->getCode()
        );
        $this->assertNotEquals(
                $durationEKAPOld, $r->getDurationEKAP()
        );
    }

    /**
     * TEST row gets deleted by id
     * can only try to delete smt what is trashed
     */
    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateVocation();
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
                ->getRepository('Core\Entity\Vocation')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {
        $entity = $this->CreateVocation();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1

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
                ->getRepository('Core\Entity\Vocation')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
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

        //prepare one Vocation with trashed flag set up
        $entity = $this->CreateVocation();
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

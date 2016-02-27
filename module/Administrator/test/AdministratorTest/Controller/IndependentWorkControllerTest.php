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
use Zend\Json\Json;

/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class IndependentWorkControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new IndependentWorkController();
        parent::setUp();
    }

    /**
     * NOT ALLOWED
     */
    public function testCreate()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testUpdate()
    {
        $this->routeMatch->setParam('id', 1); //fake id no need for real id
        $this->request->setMethod('put');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testDelete()
    {
        $this->routeMatch->setParam('id', 1); //fake id no need for real id
        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * should be successful
     */
    public function testGetList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->CreateIndependentWork();
        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);

        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * should be successful
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
        $this->routeMatch->setParam('id', $this->CreateIndependentWork()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
    }

    /**
     * should be successful
     */
    public function testGetTrashedList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //prepare one IW with trashed flag set up
        $entity = $this->CreateIndependentWork();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1
        $where = [
            'trashed' => 1,
        ];
        $whereJSON = JSON::encode($where);
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
        $this->assertEquals(true, $result->success);

        $this->assertGreaterThan(0, count($result->data));
        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }

}

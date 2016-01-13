<?php

/**
 * LIS development
 * Rest API ControllerTests
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * REST API ControllerTests
 *
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
        $this->assertEquals(false, (bool)$result->success);
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

}

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
     * Imitate POST request
     */
    public function testCreate()
    {
//        $status = uniqid(). ' Status from testCreate';
//        $student = $this->CreateStudent();
//        $studentGroup = $this->CreateStudentGroup();
//
//        $this->request->setMethod('post');
//
//        $this->request->getPost()->set('student', $student->getId());
//        $this->request->getPost()->set('studentGroup', $studentGroup->getId());
//        $this->request->getPost()->set('status', $status);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, true);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
    }
}

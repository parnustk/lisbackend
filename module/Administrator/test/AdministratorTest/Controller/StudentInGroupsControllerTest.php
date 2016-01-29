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
//    public function testCreate()
//    {
//        $durationAK = 5;
//        $description = uniqid() . ' Unique description';
//        $duedate = new \DateTime;
//        $teacher = $this->CreateTeacher();
//        $subjectRound = $this->CreateSubjectRound();
//
//        $this->request->setMethod('post');
//
//        $this->request->getPost()->set('subjectRound', $subjectRound->getId());
//        $this->request->getPost()->set('teacher', $teacher->getId());
//        $this->request->getPost()->set('duedate', $duedate);
//        $this->request->getPost()->set('description', $description);
//        $this->request->getPost()->set('durationAK', $durationAK);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, true);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//    }
}

<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace TeacherTest\Controller;

use Teacher\Controller\IndependentWorkController;
use Zend\Json\Json;
use TeacherTest\UnitHelpers;
use DateTime;

/**
 * Restrictions for student role:
 * 
 * YES getList
 * YES get
 * YES create
 * YES update - OWN CREATED
 * YES delete - OWN CREATED
 * 
 * @author Sander Mets <sandermets0@gmail.com>
 */
class IndependentWorkControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
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
        //create and set correct teacheruser
        $teacher = $this->CreateTeacher();
        $lisUser = $this->CreateTeacherUser($teacher);

        //set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($teacher);

        $subjectRound = $this->CreateSubjectRound();
        $student = $this->CreateStudent();

        $this->request->setMethod('post');

        $this->request->getPost()->set("duedate", (new DateTime)->format('Y-m-d'));
        $this->request->getPost()->set("name", uniqid() . 'Name');
        $this->request->getPost()->set("description", uniqid() . 'Description');
        $this->request->getPost()->set("durationAK", (rand(1, 10) * 2));
        $this->request->getPost()->set("subjectRound", $subjectRound->getId());
        $this->request->getPost()->set("teacher", $teacher->getId());
        $this->request->getPost()->set("student", $student->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

}

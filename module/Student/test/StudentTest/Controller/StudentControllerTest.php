<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace StudentTest\Controller;

use Student\Controller\StudentController;
use StudentTest\UnitHelpers;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of StudentControllerTest
 * 
 * @author Marten Kähr <marten@kahr.ee>
 * @author Sander Mets <sandermets0@gmail.com>
 */
class StudentControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new StudentController();
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
    public function testGetSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $student->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertEquals($student->getId(), $result->data['id']);
    }

    /**
     * should be NOT successful
     */
    public function testGetNotSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $this->request->setMethod('get');
        
        $anotherStudent = $this->CreateStudent();
        $this->routeMatch->setParam('id', $anotherStudent->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_RELATED_RESTRICTION', $result->message);
    }

    /**
     * should be NOT successful
     */
    public function testGetListSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //where can be only one student with this id, we just created only one above
        $this->assertEquals(1, count($result->data));
        $this->assertEquals($student->getId(), $result->data[0]['id']);
    }

    /**
     * should be NOT successful
     */
    public function testGetListNotSelfRelatedSelfBeenTrashed()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $student->setTrashed(1);
        $this->em->persist($student);
        $this->em->flush($student);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        //do assertions

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //where can be only one student with this id, we just created one above and trashed it
        $this->assertEquals(0, count($result->data));
    }

}

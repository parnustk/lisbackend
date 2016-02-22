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
     * should be fail with error code 405
     */
    public function testCreate()
    {   
        //start create studentuser
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);
        
        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);
        
        //test data
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();

        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
    }

//    /**
//     * should fail with error code 405
//     */
//    public function testUpdate()
//    {
//     
//    }
//
//    /**
//     * should be NOT successful
//     */
//    public function testUpdateNotSelfRelated()
//    {
//     
//    }
//
//    /**
//     * should be NOT successful
//     */
//    public function testUpdateNotSelfCreated()
//    {
//
//    }
//
//    /**
//     * should be successful
//     */
//    public function testDeleteTrashedAndSelfCreated()
//    {
//     
//    }
//
//    /**
//     * should be NOT successful
//     */
//    public function testDeleteTrashedNotSelfCreated()
//    {
//     
//    }
//
//    /**
//     * should be successful
//     */
//    public function testGetSelfRelated()
//    {
//     
//    }
//
//    /**
//     * should be NOT successful
//     */
//    public function testGetNotSelfRelated()
//    {
//     
//    }
//
//    /**
//     * should be NOT successful
//     */
//    public function testGetListSelfRelated()
//    {
//     
//    }
//
//    /**
//     * should be NOT successful
//     */
//    public function testGetListNotSelfRelated()
//    {
//     
//    }

}

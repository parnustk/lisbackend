<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuthTest\Controller;

use LisAuth\Controller\RegisterStudentController;
use Zend\Json\Json;
use LisAuthTest\UnitHelpers;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 */
class RegisterStudentControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new RegisterStudentController();
        parent::setUp();
    }

//    public function testCreateWithCorrectPersonalCodeNonExistantUser()
//    {
//        $this->assertEquals(1, 1);
//        $this->request->setMethod('post');
//
////        $this->request->getPost()->set("name", "Name vocation");
////        $this->request->getPost()->set("code", uniqid());
////        $this->request->getPost()->set("durationEKAP", 120);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, false);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//    }
    
    public function testCreateWithNoPersonalCode()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('PERSONALCODE_MISSING', $result->message);
        
    }
    
    public function testCreateWithEmptyPersonalCode()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("personalCode", null);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('PERSONALCODE_EMPTY', $result->message);
        
    }
    
    public function testCreateWithInCorrectPersonalCode()
    {
        $this->request->setMethod('post');
        $this->request->getPost()->set("personalCode", -1);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('NOT_FOUND', $result->message);
        
    }
    
//    public function testCreateAlreadyExistingStudentUser()
//    {
//        $this->request->setMethod('post');
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//        $this->PrintOut($result, false);
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//    }

}

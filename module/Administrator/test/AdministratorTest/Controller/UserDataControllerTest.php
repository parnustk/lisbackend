<?php

/**
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\UserDataController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of UserDataControllerTest
 *
 * @author Kristen Sepp <seppkristen@gmail.com>
 */
class UserDataControllerTest extends UnitHelpers
{
    protected function setUp()
    {
        $this->controller = new UserDataController();
        parent::setUp();
    }
    
    public function testGet()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $administrator->getId());
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }
    
    public function testUpdateSelfRelated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);
        
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $oldEmail = $lisUser->getEmail();
        $oldPW = $lisUser->getPassword();
        
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $lisUser->getId());
        
        $this->request->setContent(http_build_query([
            'password' => 'Test1234',
            'email' => 'updatedemail'.uniqid().'@test.ee',
        ]));
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->assertNotEquals($oldEmail, $result->data['email']);
        $this->assertNotEquals($oldPW, $result->data['password']);
    }
    
//    public function testUpdateNOTSelfRelated()
//    {
//        //create user
//        $administrator = $this->CreateAdministrator();
//        $lisUser = $this->CreateAdministratorUser($administrator);
//        
//        $this->controller->setLisUser($lisUser);
//        $this->controller->setLisPerson($administrator);
//        
//        $otherAdministrator = $this->CreateAdministrator();
//        $otherLisUser = $this->CreateAdministratorUser($otherAdministrator);
//        
//        $oldEmail = $lisUser->getEmail();
//        $oldPW = $lisUser->getPassword();
//        
//        $this->request->setMethod('put');
//        $this->routeMatch->setParam('id', $lisUser->getId());
//        
//        $this->request->setContent(http_build_query([
//            'password' => 'Test1234',
//            'email' => 'updatedemail'.uniqid().'@test.ee',
//        ]));
//        
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, TRUE);
//        
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $result->success);
//        
//        $this->assertNotEquals($oldEmail, $result->data['email']);
//        $this->assertNotEquals($oldPW, $result->data['password']);
//    }
    
}

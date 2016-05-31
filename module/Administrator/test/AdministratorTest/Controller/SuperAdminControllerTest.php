<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\SuperAdminController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of SuperAdminControllerTest
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

class SuperAdminControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SuperAdminController();
        parent::setUp();
    }

    /**
     * TEST rows get read
     * 
     * Not perfect yet because it doesn't really check if the administrator is 
     * superadministrator or not
     */
    public function testGetListasSuperAdmin()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }
    
    /**
     * Should be successful
     */
    public function testUpdateEmailAndPW()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        //create one to  update later on
        $newUser = $this->CreateLisUser();
        
        $passwordOld = $newUser->getPassword();
        $emailOld = $newUser->getEmail();
        
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $newUser->getId());
        //set new data
        $this->request->setContent(http_build_query([
            'password' => 'uuspw' . uniqid(),
            'email' => uniqid() . '@updated.ee',
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertNotEquals($passwordOld, $result->data['password']);
        $this->assertNotEquals($emailOld, $result->data['email']);
    }
    
    /**
     * Success
     */
    public function testUpdateEmailonly()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        //create one to  update later on
        $newUser = $this->CreateLisUser();
        
        $emailOld = $newUser->getEmail();
        
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $newUser->getId());
        //set new data
        $this->request->setContent(http_build_query([
            'email' => uniqid() . '@updated.ee',
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertNotEquals($emailOld, $result->data['email']);
    }
    
    /**
     * Success
     */
    public function testUpdatePWonly()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        //create one to  update later on
        $newUser = $this->CreateLisUser();
        
        $passwordOld = $newUser->getPassword();
        
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $newUser->getId());
        //set new data
        $this->request->setContent(http_build_query([
            'password' => 'uuspw' . uniqid(),
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertNotEquals($passwordOld, $result->data['password']);
    }
    
    /**
     * FAIL
     */
    public function testUpdateNoData()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        //create one to  update later on
        $newUser = $this->CreateLisUser();
        
        $passwordOld = $newUser->getPassword();
        
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $newUser->getId());
        //set new data
        $this->request->setContent(http_build_query([
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(0, $result->success);
    }
    
    /**
     * Success
     */
    public function testDelete()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        $entity = $this->CreateLisUser();
        
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\LisUser')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }
    
    /**
     * FAIL
     */
    public function testDeleteNotTrashed()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        $entity = $this->CreateLisUser();
        
        $idOld = $entity->getId();
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(0, $result->success);
        $this->em->clear();
    }

    /**
     * Sucess
     */
    public function testGetTrashedList()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        //prepare one LisUser with trashed flag set up
        $entity = $this->CreateLisUser();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1
        $where = [
            'trashed' => 1,
//            'id' => $entity->getId()  //we want to get the whole list not just one
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //limit is set to 1
        $this->assertGreaterThan(0, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }
}

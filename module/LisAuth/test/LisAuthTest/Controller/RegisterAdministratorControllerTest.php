<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuthTest\Controller;

use LisAuth\Controller\RegisterAdministratorController;
use LisAuthTest\UnitHelpers;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 */
class RegisterAdministratorControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new RegisterAdministratorController();
        parent::setUp();
    }

    /**
     * 
     */
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

    /**
     * 
     */
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

    public function testCreateNewAdministratorUser()
    {
        $administrator = $this->CreateAdministrator();

        $email = uniqid() . '@asd.com';

        $data = [
            'personalCode' => $administrator->getPersonalCode(),
            'password' => 123456,
            'email' => $email,
        ];

        $this->request->setMethod('post');

        $this->request->getPost()->set("personalCode", $data['personalCode']);
        $this->request->getPost()->set("password", $data['password']);
        $this->request->getPost()->set("email", $data['email']);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
        $this->assertEquals($email, $result->email);
    }

    public function testCreateAlreadyExistingAdministratorUser()
    {
        $administrator = $this->CreateAdministrator();

        $data = [
            'personalCode' => $administrator->getPersonalCode(),
            'password' => 123456,
            'email' => uniqid() . '@asd.ee',
        ];

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($data);

        $administrator->setLisUser($lisUser); //associate
        $this->em->persist($administrator);
        $this->em->flush($administrator);

        //now we have created studentuser, let's try to register

        $this->request->setMethod('post');

        $this->request->getPost()->set("personalCode", $data['personalCode']);
        $this->request->getPost()->set("password", $data['password']);
        $this->request->getPost()->set("email", $data['email']);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('ALREADY_REGISTERED', $result->message);
    }

    public function testCreateIncorrectAdministratorUserIncorrectEmail()
    {
        $administrator = $this->CreateAdministrator();

        $email = uniqid();

        $data = [
            'personalCode' => $administrator->getPersonalCode(),
            'password' => 123456,
            'email' => $email,
        ];

        $this->request->setMethod('post');

        $this->request->getPost()->set("personalCode", $data['personalCode']);
        $this->request->getPost()->set("password", $data['password']);
        $this->request->getPost()->set("email", $data['email']);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertNotEquals($email, $result->email);
    }

}

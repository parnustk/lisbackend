<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuthTest\Controller;

use LisAuth\Controller\LoginAdministratorController;
use LisAuthTest\UnitHelpers;
use LisAuthTest\Bootstrap;

/**
 * @author Sander Mets <sandermets0@gmail.com>
 */
class LoginAdministratorControllerTest extends UnitHelpers
{

    protected $lisRegisterService;

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new LoginAdministratorController();
        parent::setUp();
        $sm = Bootstrap::getServiceManager();
        $this->lisRegisterService = $sm->get('lisregister_service');
    }

    /**
     * Log in administrator
     */
    public function testCreateWithCorrectData()
    {
        $administrator = $this->CreateAdministrator();

        $email = uniqid() . '@test.ee';
        $password = uniqid();

        $d = [
            'personalCode' => $administrator->getPersonalCode(),
            'email' => $email,
            'password' => $password,
        ];

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $administrator->setLisUser($lisUser); //associate
        $this->em->persist($administrator);
        $this->em->flush($administrator);


        $this->request->setMethod('post');

        $this->request->getPost()->set("email", $email);
        $this->request->getPost()->set("password", $password);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, true);

        die('ajee karatee');

//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(false, $result->success);
//        $this->assertEquals('PERSONALCODE_MISSING', $result->message);
    }

}

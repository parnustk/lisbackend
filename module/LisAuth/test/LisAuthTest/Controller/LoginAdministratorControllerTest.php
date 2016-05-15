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

ob_start(); //clears error - session_regenerate_id(): Cannot regenerate session id - headers already sent
/**
 * @author Sander Mets <sandermets0@gmail.com>
 */

class LoginAdministratorControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new LoginAdministratorController();
        parent::setUp();
    }

//    /**
//     * Log in administrator
//     */
//    public function testCreateWithCorrectData()
//    {
//        $administrator = $this->CreateAdministrator();
//
//        $email = uniqid() . '@test.ee';
//        $password = uniqid();
//
//        $d = [
//            'personalCode' => $administrator->getPersonalCode(),
//            'email' => $email,
//            'password' => $password,
//        ];
//
//        $lisUser = $this
//                ->em
//                ->getRepository('Core\Entity\LisUser')
//                ->Create($d);
//
//        $administrator->setLisUser($lisUser); //associate
//        $this->em->persist($administrator);
//        $this->em->flush($administrator);
//
//        $this->request->setMethod('post');
//
//        $this->request->getPost()->set("email", $email);
//        $this->request->getPost()->set("password", $password);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, false);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(true, $result->success);
//        $this->assertEquals('NOW_LOGGED_IN', $result->message);
//    }
//
//    /**
//     * Log in administrator false password
//     */
//    public function testCreateWithFalsePassword()
//    {
//        $administrator = $this->CreateAdministrator();
//
//        $email = uniqid() . '@test.ee';
//        $password = uniqid();
//
//        $d = [
//            'personalCode' => $administrator->getPersonalCode(),
//            'email' => $email,
//            'password' => $password,
//        ];
//
//        $lisUser = $this
//                ->em
//                ->getRepository('Core\Entity\LisUser')
//                ->Create($d);
//
//        $administrator->setLisUser($lisUser); //associate
//        $this->em->persist($administrator);
//        $this->em->flush($administrator);
//
//        $this->request->setMethod('post');
//
//        $falsePassword = 'TereMaailm87654';
//        $this->request->getPost()->set("email", $email);
//        $this->request->getPost()->set("password", $falsePassword);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, false);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(false, $result->success);
//        $this->assertEquals('FALSE_ATTEMPT', $result->message);
//    }
//
//    /**
//     * Log in administrator false password
//     */
//    public function testCreateWithFalseEmail()
//    {
//        $administrator = $this->CreateAdministrator();
//
//        $email = uniqid() . '@test.ee';
//        $password = uniqid();
//
//        $d = [
//            'personalCode' => $administrator->getPersonalCode(),
//            'email' => $email,
//            'password' => $password,
//        ];
//
//        $lisUser = $this
//                ->em
//                ->getRepository('Core\Entity\LisUser')
//                ->Create($d);
//
//        $administrator->setLisUser($lisUser); //associate
//        $this->em->persist($administrator);
//        $this->em->flush($administrator);
//
//        $this->request->setMethod('post');
//
//        $falseEmail = 'tere@test.ee';
//        $this->request->getPost()->set("email", $falseEmail);
//        $this->request->getPost()->set("password", $password);
//
//        $result = $this->controller->dispatch($this->request);
//        $response = $this->controller->getResponse();
//
//        $this->PrintOut($result, false);
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(false, $result->success);
//        $this->assertEquals('FALSE_ATTEMPT', $result->message);
//    }

    /**
     * Create static user 
     * later on move this code 
     * to cron job or similar
     */
    public function testCreateStaticAdminUser()
    {
        try {

            $email = 'admin@test.ee';
            $password = 'Tere1234';

            $administratorRepository = $this->em->getRepository('Core\Entity\Administrator');

            $administrator = $administratorRepository->Create([
                'firstName' => 'firstName' . uniqid(),
                'lastName' => 'lastName' . uniqid(),
                'personalCode' => 'code' . uniqid(),
                'email' => $email
            ]);

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
        } catch (\Exception $exc) {
            $this->PrintOut($exc->getMessage(), false);
        }
    }

}

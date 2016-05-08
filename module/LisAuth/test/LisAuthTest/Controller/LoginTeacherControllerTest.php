<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuthTest\Controller;

use LisAuth\Controller\LoginTeacherController;
use LisAuthTest\UnitHelpers;

ob_start(); //clears error - session_regenerate_id(): Cannot regenerate session id - headers already sent

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Juhan Kõks <juhankoks@gmail.com>
 */
class LoginTeacherControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new LoginTeacherController();
        parent::setUp();
    }

//    /**
//     * Log in teacher
//     */
//    public function testCreateWithCorrectData()
//    {
//        $teacher = $this->CreateTeacher();
//        $email = uniqid() . '@test.ee';
//        $password = uniqid();
//
//        $d = [
//            'personalCode' => $teacher->getPersonalCode(),
//            'email' => $email,
//            'password' => $password,
//        ];
//
//        $lisUser = $this
//                ->em
//                ->getRepository('Core\Entity\LisUser')
//                ->Create($d);
//
//        $teacher->setLisUser($lisUser); //associate
//        $this->em->persist($teacher);
//        $this->em->flush($teacher);
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
//     * Log in teacher false password
//     */
//    public function testCreateWithFalsePassword()
//    {
//        $teacher = $this->CreateTeacher();
//
//        $email = uniqid() . '@test.ee';
//        $password = uniqid();
//
//        $d = [
//            'personalCode' => $teacher->getPersonalCode(),
//            'email' => $email,
//            'password' => $password,
//        ];
//
//        $lisUser = $this
//                ->em
//                ->getRepository('Core\Entity\LisUser')
//                ->Create($d);
//
//        $teacher->setLisUser($lisUser); //associate
//        $this->em->persist($teacher);
//        $this->em->flush($teacher);
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
//     * Log in teacher false email
//     */
//    public function testCreateWithFalseEmail()
//    {
//        $teacher = $this->CreateTeacher();
//
//        $email = uniqid() . '@test.ee';
//        $password = uniqid();
//
//        $d = [
//            'personalCode' => $teacher->getPersonalCode(),
//            'email' => $email,
//            'password' => $password,
//        ];
//
//        $lisUser = $this
//                ->em
//                ->getRepository('Core\Entity\LisUser')
//                ->Create($d);
//
//        $teacher->setLisUser($lisUser); //associate
//        $this->em->persist($teacher);
//        $this->em->flush($teacher);
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

    public function testCreateStaticTeacherUser()
    {
        try {

            $email = 'teacher@test.ee';
            $password = 'Tere1234';

            $teacherRepository = $this->em->getRepository('Core\Entity\Teacher');

            $teacher = $teacherRepository->Create([
                'firstName' => 'firstName' . uniqid(),
                'lastName' => 'lastName' . uniqid(),
                'personalCode' => 'code' . uniqid(),
                'email' => $email
            ]);

            $d = [
                'personalCode' => $teacher->getPersonalCode(),
                'email' => $email,
                'password' => $password,
            ];

            $lisUser = $this
                    ->em
                    ->getRepository('Core\Entity\LisUser')
                    ->Create($d);

            $teacher->setLisUser($lisUser); //associate
            $this->em->persist($teacher);
            $this->em->flush($teacher);
        } catch (\Exception $exc) {
            $this->PrintOut($exc->getMessage(), false);
        }
    }

}

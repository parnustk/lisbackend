<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace LisAuthTest\Controller;

use LisAuth\Controller\LoginStudentController;
use LisAuthTest\UnitHelpers;

ob_start(); //clears error - session_regenerate_id(): Cannot regenerate session id - headers already sent

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class LoginStudentControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new LoginStudentController();
        parent::setUp();
    }

    /**
     * Log in student
     */
    public function testCreateWithCorrectData()
    {
        $student = $this->CreateStudent();
        $email = uniqid() . '@test.ee';
        $password = uniqid();

        $d = [
            'personalCode' => $student->getPersonalCode(),
            'email' => $email,
            'password' => $password,
        ];

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

        $this->request->setMethod('post');

        $this->request->getPost()->set("email", $email);
        $this->request->getPost()->set("password", $password);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
        $this->assertEquals('NOW_LOGGED_IN', $result->message);
    }

    /**
     * Log in teacher false password
     */
    public function testCreateWithFalsePassword()
    {
        $student = $this->CreateStudent();

        $email = uniqid() . '@test.ee';
        $password = uniqid();

        $d = [
            'personalCode' => $student->getPersonalCode(),
            'email' => $email,
            'password' => $password,
        ];

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

        $this->request->setMethod('post');

        $falsePassword = 'TereMaailm87654';
        $this->request->getPost()->set("email", $email);
        $this->request->getPost()->set("password", $falsePassword);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('FALSE_ATTEMPT', $result->message);
    }

    /**
     * Log in teacher false email
     */
    public function testCreateWithFalseEmail()
    {
        $student = $this->CreateStudent();

        $email = uniqid() . '@test.ee';
        $password = uniqid();

        $d = [
            'personalCode' => $student->getPersonalCode(),
            'email' => $email,
            'password' => $password,
        ];

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

        $this->request->setMethod('post');

        $falseEmail = 'tere@test.ee';
        $this->request->getPost()->set("email", $falseEmail);
        $this->request->getPost()->set("password", $password);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('FALSE_ATTEMPT', $result->message);
    }

    public function testCreateStaticStudentUser()
    {
        try {

            $email = 'student@test.ee';
            $password = 'Tere1234';

            $studentRepository = $this->em->getRepository('Core\Entity\Student');

            $student = $studentRepository->Create([
                'firstName' => 'firstName' . uniqid(),
                'lastName' => 'lastName' . uniqid(),
                'personalCode' => 'code' . uniqid(),
                'email' => $email
            ]);

            $d = [
                'personalCode' => $student->getPersonalCode(),
                'email' => $email,
                'password' => $password,
            ];

            $lisUser = $this
                    ->em
                    ->getRepository('Core\Entity\LisUser')
                    ->Create($d);

            $student->setLisUser($lisUser); //associate
            $this->em->persist($student);
            $this->em->flush($student);
        } catch (\Exception $exc) {
            $this->PrintOut($exc->getMessage(), false);
        }
    }

}

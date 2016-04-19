<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\StudentController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of StudentControllerTest
 * 
 * @author Marten Kähr <marten@kahr.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Juhan Kõks <eleri.apsolon@gmail.com>
 */
class StudentControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new StudentController();
        parent::setUp();
    }

    /**
     * testing create without a data
     */
    public function testCreateNoData()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        //test that message contains isEmpty
        $validator = new Regex(['pattern' => '/isEmpty/U']); //U - non greedy
        $this->assertFalse($validator->isValid($result->message));
    }

    public function testCreate()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');

        $this->request->getPost()->set("personalCode", uniqid());
        $this->request->getPost()->set("firstName", uniqid());
        $this->request->getPost()->set("lastName", uniqid());
        $this->request->getPost()->set("email", uniqid() . '@create.ee');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    public function testCreateNoFirstName()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

//        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');


//        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateNoLastName()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $firstName = 'studentFirstName' . uniqid();
//        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');

        $this->request->getPost()->set('firstName', $firstName);
//        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateNoCode()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
//        $code = 'studentCode' . uniqid();
        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');


        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
//        $this->request->getPost()->set('personalCode', $code);
        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    public function testCreateNoEmail()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $firstName = 'studentFirstName' . uniqid();
        $lastName = 'studentLastName' . uniqid();
        $code = 'studentCode' . uniqid();
//        $email = 'studentEmail' . uniqid();
//        $lisUser = 'studentLisUser' . uniqid();
//        $absence = 'studentAbsence' . uniqid();
//        $studentGrade = 'studentStudentGrade' . uniqid();

        $this->request->setMethod('post');


        $this->request->getPost()->set('firstName', $firstName);
        $this->request->getPost()->set('lastName', $lastName);
        $this->request->getPost()->set('personalCode', $code);
//        $this->request->getPost()->set('email', $email);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertNotEquals(1, $result->success);
    }

    /**
     * TEST row gets read by id
     */
    public function testGet()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateStudent()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * TEST rows get read
     */
    public function testGetList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->CreateStudent();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * TEST row gets updated by id
     */
    public function testUpdate()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create student
        $entity = $this->CreateStudent();
        $id = $entity->getId();

        $firstNameOld = $entity->getFirstName();
        $lastNameOld = $entity->getLastName();
        $codeOld = $entity->getPersonalCode();
        $emailOld = $entity->getEmail();


        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            'firstName' => 'Updated',
            'lastName' => 'Updated',
            'personalCode' => uniqid(),
            'email' => 'Updated' . uniqid() . '@mail.ee',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\Student')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $firstNameOld, $r->getFirstName()
        );
        $this->assertNotEquals(
                $lastNameOld, $r->getLastName()
        );
        $this->assertNotEquals(
                $codeOld, $r->getPersonalCode()
        );
        $this->assertNotEquals(
                $emailOld, $r->getEmail()
        );
    }

    /**
     * TEST row gets deleted by id
     */
    public function testDelete()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);
        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $entity = $this->CreateStudent();
        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Student')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }

    /**
     * TEST rows get read by limit and page params
     */
    public function testGetListWithPaginaton()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('get');

        //create 2 entities
        $this->CreateStudent();
        $this->CreateStudent();

        //set record limit to 1
        $q = 'page=1&limit=1'; //imitate real param format
        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
    }

    /**
     * TEST row gets deleted by id
     * can only try to delete smt what is trashed
     */
    public function testDeleteNotTrashed()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $entity = $this->CreateStudent();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Student')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testGetTrashedList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //prepare one Teacher with trashed flag set up
        $entity = $this->CreateStudent();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity); //save to db with trashed 1
        $where = [
            'trashed' => 1,
            'id' => $entity->getId()
        ];
        $whereJSON = Json::encode($where);
        $whereURL = urlencode($whereJSON);
        $whereURLPart = "where=$whereURL";
        $q = "page=1&limit=1&$whereURLPart"; //imitate real param format

        $params = [];
        parse_str($q, $params);
        foreach ($params as $key => $value) {
            $this->request->getQuery()->set($key, $value);
        }

        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        //limit is set to 1
        $this->assertEquals(1, count($result->data));

        //assert all results have trashed not null
        foreach ($result->data as $value) {
            $this->assertEquals(1, $value['trashed']);
        }
    }

}

<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AbsenceController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class AbsenceControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new AbsenceController();
        parent::setUp();
    }

    /**
     * Should be NOT successful
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
        $this->assertEquals(false, $result->success);

        //test that message contains isEmpty
        $validator = new Regex(['pattern' => '/isEmpty/U']);//U - non greedy
        $this->assertTrue($validator->isValid($result->message));
    }

    /**
     * imitate POST request
     * create new with correct data see entity
     * creates new row to databaase
     * 
     * Should be successful
     */
    public function testCreate()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('absenceReason', $this->CreateAbsenceReason()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
         
        $this->PrintOut($result, false);
      
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThanOrEqual(1, $result->data['id']);
    }

    /**
     * Should be successful
     */
    public function testCreateWithAbsenceReason()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $description = 'Absence description' . uniqid();
        $this->request->setMethod('post');
        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());
        $this->request->getPost()->set('absenceReason', $this->CreateAbsenceReason()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThanOrEqual(1, $result->data['absenceReason']['id']);
    }

    /**
     * TEST row gets not created
     * 
     * Should be NOT successful
     */
    public function testCreateNoDescription()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $this->request->setMethod('post');

        $this->request->getPost()->set('student', $this->CreateStudent()->getId());
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        
        //test that message contains description":{"isEmpty
        $validator = new Regex(['pattern' => '/description.{4}isEmpty/U']);
        $this->assertTrue($validator->isValid($result->message));
    }
    /**
     * Should be NOT successful
     */
    public function testCreateNoStudent()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $this->request->setMethod('post');
        $description = 'Absence description' . uniqid();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('contactLesson', $this->CreateContactLesson()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        
        //test that message contains student":{"isEmpty
        $validator = new Regex(['pattern' => '/student.{4}isEmpty/U']);
        $this->assertTrue($validator->isValid($result->message));
        
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoContactLesson()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $this->request->setMethod('post');
        $description = 'Absence description' . uniqid();

        $this->request->getPost()->set('description', $description);
        $this->request->getPost()->set('student', $this->CreateStudent()->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        
        $validator = new Regex(['pattern' => '/contactLesson.{4}isEmpty/U']);
        $this->assertTrue($validator->isValid($result->message));
        
    }
    /**
     * should be successful
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
        $this->routeMatch->setParam('id', $this->CreateAbsence()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
    }

    /**
     * should be successful
     */
    public function testGetList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $this->CreateAbsence();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
     * Own related restriction
     * 
     * should be successful
     */
    public function testUpdateSelfCreated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to  update later on
//        $absence = $this->CreateAbsence();

        $repository = $this->em->getRepository('Core\Entity\Absence');

        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();

        $absence = $repository->Create([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $studentIdOld = $absence->getStudent()->getId();
        $contactLessonIdOld = $absence->getContactLesson()->getId();
        $absenceReasonIdOld = $absence->getAbsenceReason()->getId();

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);

        $this->assertNotEquals($studentIdOld, $result->data['student']['id']);
        $this->assertNotEquals($contactLessonIdOld, $result->data['contactLesson']['id']);
        $this->assertNotEquals($absenceReasonIdOld, $result->data['absenceReason']['id']);
    }

    /**
     * Own related restriction
     * 
     * should be NOT successful
     */
    public function testUpdateNotSelfCreated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to  update later on
        $repository = $this->em->getRepository('Core\Entity\Absence');

        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();

        $anotherAdministrator = $this->CreateAdministrator();
        $anotherLisUser = $this->CreateAdministratorUser($anotherAdministrator);

        $absence = $repository->Create([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $anotherLisUser->getId()
        ]);

        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $absence->getId());

        $this->request->setContent(http_build_query([
            'contactLesson' => $this->CreateContactLesson()->getId(),
            'student' => $this->CreateStudent()->getId(),
            'absenceReason' => $this->CreateAbsenceReason()->getId(),
        ]));

        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);
    }

    /**
     * Sohuld be NOT successful
     */
    public function testDeleteNotTrashed()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        $entity = $this->CreateAbsence();
        $idOld = $entity->getId();

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('NOT_TRASHED', $result->message);

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Absence')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    /**
     * Sohuld be NOT successful
     */
    public function testDeleteNotOwnCreated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to  update later on
        $repository = $this->em->getRepository('Core\Entity\Absence');

        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();

        $anotherAdministrator = $this->CreateAdministrator();
        $anotherLisUser = $this->CreateAdministratorUser($anotherAdministrator);

        $entity = $repository->Create([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $anotherLisUser->getId()
        ]);

        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_CREATED_RESTRICTION', $result->message);

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Absence')
                ->find($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    /**
     * Sohuld be successful
     */
    public function testDeleteOwnCreated()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to  update later on
        $repository = $this->em->getRepository('Core\Entity\Absence');

        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();

        $entity = $repository->Create([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);

        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);

        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\Absence')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
    }

    /**
     * TEST rows get read by limit and page params
     * Should be successful
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
        $this->assertEquals(true, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
    }

    /**
     * Should be successful
     */
    public function testUpdateToTrashed()
    {
        //create one to update later
        
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to  update later on
        $repository = $this->em->getRepository('Core\Entity\Absence');

        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();

        $entity = $repository->Create([
            'description' => uniqid() . 'AbsenceDescription',
            'absenceReason' => $absenceReason->getId(),
            'student' => $student->getId(),
            'contactLesson' => $contactLesson->getId(),
            'createdBy' => $lisUser->getId()
        ]);
        
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        
        $this->request->setContent(http_build_query([
            'trashed' => 1,
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $result->success);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\Absence')
                ->find($result->data['id']);
        
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
    }

    public function testGetTrashedList()
    {
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);
        
        //prepare one AbsenceReason with trashed flag set up
        $entity = $this->CreateAbsence();
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

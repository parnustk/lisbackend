<?php

/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectRoundController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
class SubjectRoundControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectRoundController();
        parent::setUp();
    }

    /**
     * Imitate POST request
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

        $this->request->setMethod('post');
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
        $module = $this->CreateModule();
        $this->request->getPost()->set("module", $module->getId());
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set("vocation", $vocation->getId());
        $teacher = [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ];
        $this->request->getPost()->set("teacher", $teacher);
        $this->request->getPost()->set('name', 'AB alused');
        $this->request->getPost()->set('status', 2);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
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
        $this->assertNotEquals(1, $result->success);

        //test that message contains isEmpty
        $validator = new Regex(['pattern' => '/isEmpty/U']); //U - non greedy
        $this->assertFalse($validator->isValid($result->message));
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoSubject()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $this->request->getPost()->set("studentGroup", $this->CreateStudentGroup()->getId());
        $module = $this->CreateModule();
        $this->request->getPost()->set("module", $module->getId());
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set("vocation", $vocation->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);

        //test that message contains subject":{"isEmpty
        $validator = new Regex(['pattern' => '/subject.{4}isEmpty/U']);
        $this->assertFalse($validator->isValid($result->message));
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoStudentGroup()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $module = $this->CreateModule();
        $this->request->getPost()->set("module", $module->getId());
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set("vocation", $vocation->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);

        //test that message contains studentGroup":{"isEmpty
        $validator = new Regex(['pattern' => '/studentGroup.{4}isEmpty/U']);
        $this->assertTrue($validator->isValid($result->message));
    }

    /**
     * Should be NOT successful
     */
    public function testCreateNoTeacher()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
        $module = $this->CreateModule();
        $this->request->getPost()->set("module", $module->getId());
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set("vocation", $vocation->getId());
        $result = $this->controller->dispatch($this->request);

        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);

        //test that message contains No result was found
        $validator = new Regex(['pattern' => '/No result was found/U']);
        $this->assertTrue($validator->isValid($result->message));
    }

    /**
     * Should be successful
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
        $this->routeMatch->setParam('id', $this->CreateSubjectRound()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * Should be successful
     */
    public function testUpdate()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to  update later on
        $subjectRound = $this->CreateSubjectRound();
        
        $studentGroupIdOld = $subjectRound->getStudentGroup()->getId();
        $moduleIdOld = $subjectRound->getModule()->getId();
        $vocationIdOld = $subjectRound->getVocation()->getId();
        $subjectIdOld = $subjectRound->getSubject()->getId();
        $teachersOld = [];
        foreach ($subjectRound->getTeacher() as $teacherOld) {
            $teachersOld[] = [
                'id' => $teacherOld->getId()
            ];
        }
        //prepare request
        $this->request->setMethod('put');
        $this->routeMatch->setParam('id', $subjectRound->getId());
        //set new data
        $teacher1 = $this->CreateTeacher();
        $teacher2 = $this->CreateTeacher();

        $teachers = [
            [
                'id' => $teacher1->getId()
            ],
            [
                'id' => $teacher2->getId()
            ]
        ];
        $this->request->setContent(http_build_query([
            'subject' => $this->CreateSubject()->getId(),
            'studentGroup' => $this->CreateStudentGroup()->getId(),
            'module' => $this->CreateModule()->getId(),
            'vocation' => $this->CreateVocation()->getId(),
            "teacher" => $teachers,
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertNotEquals($studentGroupIdOld, $result->data['studentGroup']['id']);
        $this->assertNotEquals($subjectIdOld, $result->data['subject']['id']);
        $this->assertNotEquals($moduleIdOld, $result->data['module']['id']);
        $this->assertNotEquals($vocationIdOld, $result->data['vocation']['id']);
        foreach ($teachersOld as $teacherOld) {//no double check figured out, pure linear looping
            foreach ($result->data['teacher'] as $teacherU) {
                $this->assertNotEquals($teacherOld['id'], $teacherU['id']);
            }
        }
    }

    /**
     * Should be NOT successful
     */
    public function testDeleteNotTrashed()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $entity = $this->CreateSubjectRound();
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
                ->getRepository('Core\Entity\SubjectRound')
                ->Get($idOld);
        $this->assertNotEquals(null, $deleted);
    }

    /**
     * Should be successful
     */
    public function testDelete()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $entity = $this->CreateSubjectRound();
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
        $this->assertEquals(1, $result->success);
        $this->em->clear();
        //test if it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\SubjectRound')
                ->find($idOld);
        $this->assertEquals(null, $deleted);
        $this->PrintOut($result, false);
    }

    /**
     * Should be successful
     */
    public function testGetList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->CreateSubjectRound();
        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }

    /**
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
        //create 2 entities
        $this->CreateSubjectRound();
        $this->CreateSubjectRound();
        //set record limit to 1
        $q = 'page=1&limit=1';
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
     * Should be successful
     */
    public function testCreatedAtAndUpdatedAt()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        $this->request->setMethod('post');
        $subject = $this->CreateSubject();
        $this->request->getPost()->set("subject", $subject->getId());
        $module = $this->CreateModule();
        $this->request->getPost()->set("module", $module->getId());
        $vocation = $this->CreateVocation();
        $this->request->getPost()->set("vocation", $vocation->getId());
        $this->request->getPost()->set("teacher", [
            ['id' => $this->CreateTeacher()->getId()],
            ['id' => $this->CreateTeacher()->getId()],
        ]);
        $studentGroup = $this->CreateStudentGroup();
        $this->request->getPost()->set("studentGroup", $studentGroup->getId());
        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $repository = $this->em->getRepository('Core\Entity\SubjectRound');
        $newSubjectRound = $repository->find($result->data['id']);
        $this->assertNotNull($newSubjectRound->getCreatedAt());
        $this->assertNull($newSubjectRound->getUpdatedAt());
    }

    /**
     * Should be successful
     */
    public function testGetTrashedList()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //prepare one Module with trashed flag set up
        $entity = $this->CreateSubjectRound();
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

    /**
     * Should be successful
     */
    public function testTrashed()
    {
        //create user
        $administrator = $this->CreateAdministrator();
        $lisUser = $this->CreateAdministratorUser($administrator);

        //now we have created adminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($administrator);

        //create one to update later
        $entity = $this->CreateSubjectRound();
        $id = $entity->getId();
        $trashedOld = $entity->getTrashed();
        //prepare request
        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'trashed' => 1,
            'id' => $id
        ]));
        //fire request
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        //set new data
        $repository = $this->em
                ->getRepository('Core\Entity\SubjectRound')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $repository->getTrashed()
        );
    }

}

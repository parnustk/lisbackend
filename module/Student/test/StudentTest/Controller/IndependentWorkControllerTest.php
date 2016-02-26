<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

namespace StudentTest\Controller;

use Student\Controller\IndependentWorkController;
use Zend\Json\Json;
use StudentTest\UnitHelpers;

/**
 * Restrictions for student role:
 * 
 * YES getList
 * YES get
 * 
 * @author Alar Aasa <alar@alaraasa.ee>
 */
class IndependentWorkControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new IndependentWorkController();
        parent::setUp();
    }

    /**
     * NOT ALLOWED
     */
    public function testCreate()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);
        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * NOT ALLOWED
     */
    public function testUpdate()
    {
        $this->routeMatch->setParam('id', 1);
        $this->request->setMethod('put');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * Should be NOT successful
     */
    public function testDelete()
    {
        $this->routeMatch->setParam('id', 1);
        $this->request->setMethod('delete');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);
        $this->assertEquals(405, $response->getStatusCode());
    }

    /**
     * TEST row gets read by id
     */
    public function testGet()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateIndependentWork()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
    }

    /**
     * Should be NOT successful
     */
    public function testGetNotSelfRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $subjectRound = $this->CreateSubjectRound();
        $teacher = $this->CreateTeacher();
        $anotherStudent = $this->CreateStudent();

        $repository = $this->em->getRepository('Core\Entity\IndependentWork');
        $independentWork = $repository->Create([
            'duedate' => new \DateTime,
            'description' => uniqid() . ' Description for independentwork',
            'durationAK' => (int) uniqid(),
            'subjectRound' => $subjectRound->getId(),
            'teacher' => $teacher->getId(),
            'student' => $anotherStudent->getId()
        ]);

        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $independentWork->getId());

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(false, $result->success);
        $this->assertEquals('SELF_RELATED_RESTRICTION', $result->message);
    }

    /**
     * should be successful
     */
    public function testGetListNoAnotherStudentRelated()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        $subjectRound = $this->CreateSubjectRound();
        $teacher = $this->CreateTeacher();
        $anotherStudentId = $this->CreateStudent()->getId();

        $repository = $this->em->getRepository('Core\Entity\IndependentWork');
        $repository->Create([
            'duedate' => new \DateTime,
            'description' => uniqid() . ' Description for independentwork',
            'durationAK' => (int) uniqid(),
            'subjectRound' => $subjectRound->getId(),
            'teacher' => $teacher->getId(),
            'student' => $anotherStudentId
        ]);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));

        foreach ($result->data as $iw) {
            $this->assertNotEquals($anotherStudentId, $iw['id']);
        }
    }

    /**
     * TEST rows get read by limit and page params
     */
    public function testGetListWithPaginaton()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

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
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testGetTrashedList()
    {
        //create user
        $student = $this->CreateStudent();
        $lisUser = $this->CreateStudentUser($student);

        //now we have created studentuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($student);

        //prepare one Administrator with trashed flag set up
        $entity = $this->CreateIndependentWork();
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
    }

}

<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\ModuleTypeController;
use Zend\Json\Json;

//error_reporting(E_ALL | E_STRICT);
//chdir(__DIR__);

/**
 * @author Sander Mets <sandermets0@gmail.com>, Alar Aasa <alar@alaraasa.ee>, Eleri Apsolon <eleri.apsolon@gmailcom>
 */
class ModuletypeControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new ModuletypeController();
        parent::setUp();
    }

    public function testCreate()
    {
        $name = 'Moduletype name' . uniqid();

        $this->request->setMethod('post');

        $room = $this->CreateModuleType();
        $this->request->getPost()->set('name', $name);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateModuleType()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
    }

    public function testGetList()
    {

        $this->CreateModuleType();
        $this->request->setMethod('get');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        
    }

    public function testUpdate()
    {
        $entity = $this->CreateModuleType();
        $id = $entity->getId();
        $nameOld = $entity->getName();

        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');
        $this->request->setContent(http_build_query([
            'name' => 'Updated' . uniqid(),
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, FALSE);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\ModuleType')
                ->find($result->data['id']);
        $this->assertNotEquals($nameOld, $r->getName());
    }
    
    public function testDeleteNotTrashed()
    {
        $entity = $this->CreateModuleType();
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
                ->getRepository('Core\Entity\ModuleType')
                ->Get($idOld);

        $this->assertNotEquals(null, $deleted);
    }

    public function testDelete()
    {
        $entity = $this->CreateModuleType();
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

        //test it is not in the database anymore
        $deleted = $this->em
                ->getRepository('Core\Entity\ModuleType')
                ->find($idOld);

        $this->assertEquals(null, $deleted);
        
    }

    public function testCreatedByAndUpdatedBy()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set('name', uniqid() . 'ModuleType');

        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, false);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        

        $repository = $this->em->getRepository('Core\Entity\ModuleType');
        $newModuleType = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newModuleType->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newModuleType->getUpdatedBy()->getId());
    }

    public function testCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');

        $this->request->getPost()->set('name', uniqid());

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, false);

        $repository = $this->em->getRepository('Core\Entity\ModuleType');
        $newModuleType = $repository->find($result->data['id']);
        $this->assertNotNull($newModuleType->getCreatedAt());
        $this->assertNull($newModuleType->getUpdatedAt());
    }

    public function testGetListWithPagination()
    {
        $this->request->setMethod('get');

        $this->CreateModuleType();
        $this->CreateModuleType();

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

    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateModuleType();
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
        $this->assertEquals(1, $result->success);
        //set new data
        $r = $this->em
                ->getRepository('Core\Entity\ModuleType')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
    }
    
     public function testGetTrashedList()
    {

        //prepare one ModuleType with trashed flag set up
        $entity = $this->CreateModuleType();
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
     * TEST rows get read by limit and page params
     */
    public function testGetListWithPaginaton()
    {
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
        $this->assertEquals(1, $result->success);
        $this->assertLessThanOrEqual(1, count($result->data));
        
    }

}

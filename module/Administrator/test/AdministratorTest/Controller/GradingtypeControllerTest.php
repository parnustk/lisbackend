<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\GradingtypeController;

/**
 * @author Sander Mets <sandermets0@gmail.com>, Alar Aasa <alar@alaraasa.ee>
 */
class GradingtypeControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new GradingtypeController();
        parent::setUp();
    }

    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
    public function testCreate()
    {
        $name = 'Gradingtype name' . uniqid();
        
        $this->request->setMethod('post');
        
        $this->request->getPost()->set('gradingType', $name);
        
        $result = $this->controller->dispatch($this->request);       
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        
        $this->PrintOut($result, false);
    }

    public function testGet()
    {
        $this->request->setMethod('get');
        $this->routeMatch->setParam('id', $this->CreateGradingType()->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
    }

    public function testGetList()
    {
        $this->CreateGradingType();
        $this->request->setMethod('get');
        
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
        $this->PrintOut($result, false);
    }

    public function testUpdate()
    {
        $entity = $this->CreateGradingType();
        $id = $entity->getId();

        $nameOld = $entity->getGradingType();

        $this->routeMatch->setParam('id', $id);
        $this->request->setMethod('put');

        $this->request->setContent(http_build_query([
            "gradingType" => uniqid() . ' gradingType-Updated',
        ]));

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);

        $r = $this->em
                ->getRepository('Core\Entity\GradingType')
                ->find($result->data['id']);

        $this->assertNotEquals(
                $nameOld, $r->getGradingType()
        );

        $this->PrintOut($result, false);
    }

    public function testDelete()
    {
        $entity = $this->CreateGradingType();

        $idOld = $entity->getId();
        $entity->setTrashed(1);
        $this->em->persist($entity);
        $this->em->flush($entity);

        $this->routeMatch->setParam('id', $entity->getId());
        $this->request->setMethod('delete');

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->em->clear();

        //test it is not in the database anymore
        $deletedModule = $this->em
                ->getRepository('Core\Entity\GradingType')
                ->Get($idOld);

        $this->assertEquals(null, $deletedModule);
        $this->PrintOut($result, false);
    }

    public function testCreatedByAndUpdatedBy(){
        $this->request->setMethod('post');

        $name = uniqid() . 'gradingType';
        $this->request->getPost()->set("gradingType", $name);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());

        /////
        $lisUserCreates = $this->CreateLisUser();
        $lisUserCreatesId = $lisUserCreates->getId();
        $this->request->getPost()->set("createdBy", $lisUserCreatesId);

        $lisUserUpdates = $this->CreateLisUser();
        $lisUserUpdatesId = $lisUserUpdates->getId();
        $this->request->getPost()->set("updatedBy", $lisUserUpdatesId);
        ///////

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);

        $repository = $this->em->getRepository('Core\Entity\GradingType');
        $newAdministrator = $repository->find($result->data['id']);
        $this->assertEquals($lisUserCreatesId, $newAdministrator->getCreatedBy()->getId());
        $this->assertEquals($lisUserUpdatesId, $newAdministrator->getUpdatedBy()->getId());
    }
    
    
    public function testCreatedAtAndUpdatedAt()
    {
        $this->request->setMethod('post');
        
        $name = uniqid() . 'gradingtype';
        $this->request->getPost()->set('gradingType', $name);

        $lisUser = $this->CreateLisUser();
        $this->request->getPost()->set("lisUser", $lisUser->getId());
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->PrintOut($result, false);
        
        $repository = $this->em->getRepository('Core\Entity\GradingType');
        $newGt = $repository->find($result->data['id']);
        $this->assertNotNull($newGt->getCreatedAt());
        $this->assertNotNull($newGt->getUpdatedAt());
        
    }
    
    public function testGetListWithPagination()
    {
        $this->request->setMethod('get');
        
        $this->CreateGradingType();
        $this->CreateGradingType();
        
        $q = 'page=1&limit=1';
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
    
    public function testTrashed()
    {
        //create one to update later
        $entity = $this->CreateGradingType();
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
                ->getRepository('Core\Entity\Gradingtype')
                ->find($result->data['id']);
        $this->assertNotEquals(
                $trashedOld, $r->getTrashed()
        );
    }
}

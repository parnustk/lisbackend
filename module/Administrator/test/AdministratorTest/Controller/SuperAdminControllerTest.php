<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\SuperAdminController;
use Zend\Json\Json;
use Zend\Validator\Regex;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Description of SuperAdminControllerTest
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

class SuperAdminControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SuperAdminController();
        parent::setUp();
    }

    /**
     * TEST rows get read
     */
    public function testGetList()
    {
        //create user
        $superAdmin = $this->CreateSuperAdministrator();
        $lisUser = $this->CreateAdministratorUser($superAdmin);

        //now we have created superadminuser set to current controller
        $this->controller->setLisUser($lisUser);
        $this->controller->setLisPerson($superAdmin);

        $this->request->setMethod('get');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->PrintOut($result, true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $result->success);
        $this->assertGreaterThan(0, count($result->data));
    }


}

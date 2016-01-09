<?php

/**
 * LIS development
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 Lis Team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace AdministratorTest\Controller;

use Administrator\Controller\AdministratorController;

/**
 * Description of AdministratorControllerTest
 *
 * @author Sander Mets <sandermets0@gmail.com>
 */
class AdministratorControllerTest extends UnitHelpers
{

    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new AdministratorController();
        parent::setUp();
    }
    
    /**
     * TEST row gets not created
     */
    public function testCreateNoData()
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(1, $result->success);
        $this->PrintOut($result, false);
    }
    
}

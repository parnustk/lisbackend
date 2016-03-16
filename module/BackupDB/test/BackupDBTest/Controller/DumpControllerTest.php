<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace BackupDBTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */

/**
 * Description of DumpControllerTest
 *
 */
class DumpControllerTest extends AbstractHttpControllerTestCase
{

    /**
     * http://framework.zend.com/manual/current/en/modules/zend.test.phpunit.html
     */
    protected function setUp()
    {
        $this->setApplicationConfig(
                include "../../../../config/autoload/{,*.}{global,local}.php"
        );
        
        parent::setUp();
    }

    /**
     * Real URL /backupdb
     */
    public function testCreateWithNoPersonalCode()
    {
        $this->dispatch('/backupdb/dump');
        $this->assertResponseStatusCode(200);
    }

}

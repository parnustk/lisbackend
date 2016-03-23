<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace BackupDBTest\Controller;

use BackupDB\Controller\DumpController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author Marten Kähr <marten@kahr.ee>
 */
class DumpControllerTest extends UnitHelpers
{
    
    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new DumpController();
        parent::setUp();
    }
    
    /**
     * Should be successful
     */
    public function testCreateManualDump() 
    {
        $this->request->setMethod('post');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        
        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals('successM', $result->success);
    }
}
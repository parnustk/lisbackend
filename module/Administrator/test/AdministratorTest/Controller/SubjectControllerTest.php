<?php

namespace AdministratorTest\Controller;

use Administrator\Controller\SubjectController;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * @author sander
 */
class SubjectControllerTest extends UnitHelpers
{

    protected function setUp()
    {
        $this->controller = new SubjectController();
        parent::setUp();
    }

    public function testDummy()
    {
        
    }

}

<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

namespace TeacherTest\Controller;

/**
 * Description of StudentGradeControllerTest
 *
 * @author Marten Kähr
 */
class StudentGradeControllerTest extends UnitHelpers
{
    /**
     * REST access setup
     */
    protected function setUp()
    {
        $this->controller = new StudentGradeController();
        parent::setUp();
    }
}

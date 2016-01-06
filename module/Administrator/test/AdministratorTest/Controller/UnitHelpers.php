<?php

namespace AdministratorTest\Controller;

use AdministratorTest\Bootstrap;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;

/**
 * Description of UnitHelpers
 *
 * @author sander
 */
abstract class UnitHelpers extends \PHPUnit_Framework_TestCase
{

    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected $em;

    /**
     * Common setup for testing controllers
     */
    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
        $this->em = $this->controller->getEntityManager();
    }

    /**
     * Print to terminal
     * @param type $v
     * @param type $print
     */
    protected function PrintOut($v, $print = false)
    {
        if ($print) {
            echo "\n";
            echo "\t";
            print_r($v);
            echo "\n";
        }
    }

    /**
     * Vocation
     * 
     * @param array $data | null
     * @return Core\Entity\Vocation
     */
    protected function CreateVocation($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Vocation');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => 'VocationName',
                    'code' => uniqid(),
                    'durationEKAP' => '12',
        ]);
    }

    /**
     * ModuleType
     * 
     * @param array $data | null
     * @return Core\Entity\ModuleType
     */
    protected function CreateModuleType($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\ModuleType');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => 'ModuleTypeName',
        ]);
    }

    /**
     * GradingType
     * 
     * @param array $data | null
     * @return Core\Entity\GradingType
     */
    protected function CreateGradingType($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\GradingType');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'gradingType' => 'GradingTypeName',
        ]);
    }

    /**
     * Module
     * 
     * @param array $data | null
     * @return Core\Entity\Module
     */
    protected function CreateModule($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Module');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'code' => uniqid(),
                    'name' => 'asd',
                    'duration' => 12,
                    'vocation' => $this->CreateVocation()->getId(),
                    'moduleType' => $this->CreateModuleType()->getId(),
                    'gradingType' => [
                        ['id' => $this->CreateGradingType()->getId()],
                        ['id' => $this->CreateGradingType()->getId()]
                    ],
        ]);
    }

    /**
     * Subject
     * 
     * @param array $data | null
     * @return Core\Entity\Subject
     */
    protected function CreateSubject($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Subject');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'code' => uniqid(),
                    'name' => 'asd',
                    'durationAllAk' => 30,
                    'durationContactAk' => 20,
                    'durationIndependentAk' => 10,
                    'module' => $this->CreateModule()->getId(),
                    'gradingType' => [
                        ['id' => $this->CreateGradingType()->getId()],
                        ['id' => $this->CreateGradingType()->getId()]
                    ],
        ]);
    }

    /**
     * StudentGroup
     * 
     * @param array $data | null
     * @return Core\Entity\StudentGroup
     */
    protected function CreateStudentGroup($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\StudentGroup');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => 'asd',
                    'vocation' => $this->CreateVocation()->getId(),
        ]);
    }

    /**
     * Student
     * 
     * @param array $data | null
     * @return Core\Entity\Student
     */
    protected function CreateStudent($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Student');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
            'firstName' => 'firstName'.uniqid(),
            'lastName' => 'lastName'.uniqid(),
            'code' => 'code'.uniqid(),
            'email' => 'email'.uniqid(),
            'studentGroup' => $this->CreateStudentGroup()->getId()
        ]);
    }

    /**
     * Teacher
     * 
     * @param type $data
     * @return Core\Entity\Teacher
     */
    protected function CreateTeacher($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Teacher');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'firstName' => 'tFirstName' . uniqid(),
                    'lastName' => 'tLirstName' . uniqid(),
                    'code' => uniqid(),
                    'email' => uniqid() . '@asd.ee',
        ]);
    }

    /**
     * 
     * @param type $data
     * @return Core\Entity\SubjectRound
     */
    protected function CreateSubjectRound($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\SubjectRound');
        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'subject' => $this->CreateSubject()->getId(),
                    'studentGroup' => $this->CreateStudentGroup()->getId(),
                    'teacher' => [
                        ['id' => $this->CreateTeacher()->getId()],
                        ['id' => $this->CreateTeacher()->getId()],
                    ],
        ]);

        /* seems to work also
          return $repository->Create([
          'subject' => $this->CreateSubject()->getId(),
          'studentGroup' => $this->CreateStudentGroup()->getId(),
          'teacher' => [$this->CreateTeacher(), $this->CreateTeacher()],
          ]);
         */
    }

    protected function CreateContactLesson($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\ContactLesson');
        if ($data) {
            return $repository->Create($data);
        }

        $subjectRound = $this->CreateSubjectRound();

        $teachers = [];
        foreach ($subjectRound->getTeacher() as $teacher) {
            $teachers[] = [
                'id' => $teacher->getId()
            ];
        }

        return $repository->Create([
                    'lessonDate' => new \DateTime,
                    'description' => uniqid() . ' Description for contactlesson',
                    'durationAK' => 6,
                    'subjectRound' => $subjectRound->getId(),
                    'teacher' => $teachers,
        ]);
    }

}

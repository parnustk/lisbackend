<?php

namespace LisAuthTest;

use LisAuthTest\Bootstrap;
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
                    'vocationCode' => uniqid(),
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
                    'name' => 'GradingTypeName',
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
                    'moduleCode' => uniqid(),
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
                    'subjectCode' => uniqid(),
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
                    'name' => 'StudentGroup' . uniqid(),
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
                    'firstName' => 'firstName' . uniqid(),
                    'lastName' => 'lastName' . uniqid(),
                    'personalCode' => 'code' . uniqid(),
                    'email' => 'stdntemail' . uniqid() . '@gmail.com'
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
                    'personalCode' => uniqid(),
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

    /**
     * ContactLesson
     * 
     * @param type $data
     * @return type
     */
    protected function CreateContactLesson($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\ContactLesson');
        if ($data) {
            return $repository->Create($data);
        }

        $subjectRound = $this->CreateSubjectRound();

        return $repository->Create([
                    'lessonDate' => new \DateTime,
                    'description' => uniqid() . ' Description for contactlesson',
                    'durationAK' => 6,
                    'subjectRound' => $subjectRound->getId(),
                    'teacher' => [
                        ['id' => $this->CreateTeacher()->getId()],
                        ['id' => $this->CreateTeacher()->getId()],
                    ],
        ]);
    }

    /**
     * AbsenceReason
     * @author Eleri Apsolon <eleri.apsolon@gmail.com>
     * 
     * @param type $data
     * @return type
     */
    protected function CreateAbsenceReason($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\AbsenceReason');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => uniqid() . 'AbsenceReasonName',
        ]);
    }

    protected function CreateLisUser($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\LisUser');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'email' => uniqid() . '@test.ee',
                    'password' => uniqid() . '123456TereMaailm',
                    'state' => 1
        ]);
    }

    protected function CreateRoom($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Rooms');

        if ($data) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'name' => uniqid() . 'RoomName',
        ]);
    }

    protected function CreateAdministrator($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Administrator');

        if ($data !== null) {
            return $repository->Create($data);
        }

        return $repository->Create([
                    'firstName' => 'firstName' . uniqid(),
                    'lastName' => 'lastName' . uniqid(),
                    'personalCode' => 'code' . uniqid(),
                    'email' => 'adminemail' . uniqid() . '@mail.ee'
        ]);
    }

    /**
     * GradeChoice
     * 
     * @param type $data
     * @return type
     */
    protected function CreateGradeChoice($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\GradeChoice');
        if ($data) {
            return $repository->Create($data);
        }
        return $repository->Create([
                    'name' => uniqid() . 'GradeChoiceName'
        ]);
    }

    /**
     * IndependentWork
     * 
     * @param type $data
     * @return type
     */
    protected function CreateIndependentWork($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\IndependentWork');
        if ($data) {
            return $repository->Create($data);
        }

        $subjectRound = $this->CreateSubjectRound();
        $teacher = $this->CreateTeacher();

        return $repository->Create([
                    'duedate' => new \DateTime,
                    'description' => uniqid() . ' Description for independentwork',
                    'durationAK' => (int) uniqid(),
                    'subjectRound' => $subjectRound->getId(),
                    'teacher' => $teacher->getId(),
        ]);
    }

    /**
     * Absence
     * @author Eleri Apsolon <eleri.apsolon@gmail.com>
     * 
     * @param type $data
     * @return type
     */
    protected function CreateAbsence($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\Absence');

        if ($data) {
            return $repository->Create($data);
        }

        $absenceReason = $this->CreateAbsenceReason();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();

        return $repository->Create([
                    'description' => uniqid() . 'AbsenceDescription',
                    'absenceReason' => $absenceReason->getId(),
                    'student' => $student->getId(),
                    'contactLesson' => $contactLesson->getId(),
        ]);
    }

    protected function CreateStudentGrade($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\StudentGrade');

        if ($data) {
            return $repository->Create($data);
        }

        $gradeChoice = $this->CreateGradeChoice();
        $contactLesson = $this->CreateContactLesson();
        $student = $this->CreateStudent();
        $teacher = $this->CreateTeacher();
        $independentWork = $this->CreateIndependentWork();
        $module = $this->CreateModule();
        $subjectRound = $this->CreateSubjectRound();

        return $repository->Create([
                    'notes' => uniqid() . 'StudentGradeNotes',
                    'gradeChoice' => $gradeChoice->getId(),
                    'student' => $student->getId(),
                    'teacher' => $teacher->getId(),
                    'contactLesson' => $contactLesson->getId(),
                        //'independentWork'=> $independentWork->getId(),
                        //'module' => $module->getId(),
                        //'subjectRound' => $subjectRound->getId(),                  
        ]);
    }

    /**
     * StudentInGroups
     * 
     * @param type $data
     * @return type
     */
    protected function CreateStudentInGroups($data = null)
    {
        $repository = $this->em->getRepository('Core\Entity\StudentInGroups');
        if ($data) {
            return $repository->Create($data);
        }

        $student = $this->CreateStudent();
        $studentGroup = $this->CreateStudentGroup();

        return $repository->Create([
                    'status' => rand(0, 1),
                    'studentGroup' => $studentGroup->getId(),
                    'student' => $student->getId(),
        ]);
    }

    /**
     * Creates lisUser and associates to given Student
     * 
     * @param \Core\Entity\Student $student
     * @param array|null $data
     * 
     * @return \Core\Entity\LisUser
     */
    protected function CreateStudentUser(\Core\Entity\Student $student, $data = null)
    {
        $d = $data;

        if (!$d) {//if $data was not given
            $d = [
                'personalCode' => $student->getPersonalCode(),
                'password' => uniqid(),
                'email' => uniqid() . '@asd.ee',
            ];
        }

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $student->setLisUser($lisUser); //associate
        $this->em->persist($student);
        $this->em->flush($student);

        return $lisUser;
    }

    /**
     * Creates lisUser and associates to given Teacher
     * 
     * @param \Core\Entity\Teacher $teacher
     * @param array|null $data
     * 
     * @return \Core\Entity\LisUser
     */
    protected function CreateTeacherUser(\Core\Entity\Teacher $teacher, $data = null)
    {
        $d = $data;

        if (!$d) {//if $data was not given
            $d = [
                'personalCode' => $teacher->getPersonalCode(),
                'password' => uniqid(),
                'email' => uniqid() . '@asd.ee',
            ];
        }

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $teacher->setLisUser($lisUser); //associate
        $this->em->persist($teacher);
        $this->em->flush($teacher);

        return $lisUser;
    }

    /**
     * Creates lisUser and associates to given Administrator
     * 
     * @param \Core\Entity\Administrator $administrator
     * @param array|null $data
     * 
     * @return \Core\Entity\LisUser
     */
    protected function CreateAdministratorUser(\Core\Entity\Administrator $administrator, $data = null)
    {
        $d = $data;

        if (!$d) {//if $data was not given
            $d = [
                'personalCode' => $administrator->getPersonalCode(),
                'password' => uniqid(),
                'email' => uniqid() . '@asd.ee',
            ];
        }

        $lisUser = $this
                ->em
                ->getRepository('Core\Entity\LisUser')
                ->Create($d);

        $administrator->setLisUser($lisUser); //associate
        $this->em->persist($administrator);
        $this->em->flush($administrator);

        return $lisUser;
    }

}

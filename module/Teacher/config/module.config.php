<?php

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */
return [

    'controllers' => [

        'invokables' => [
            'Teacher\Controller\Absence' => 'Teacher\Controller\AbsenceController',
            'Teacher\Controller\AbsenceReason' => 'Teacher\Controller\AbsenceReasonController',
            'Teacher\Controller\Administrator' => 'Teacher\Controller\AdministratorController',
            'Teacher\Controller\ContactLesson' => 'Teacher\Controller\ContactLessonController',
            'Teacher\Controller\GradeChoice' => 'Teacher\Controller\GradeChoiceController',
            'Teacher\Controller\GradingType' => 'Teacher\Controller\GradingTypeController',
            'Teacher\Controller\IndependentWork' => 'Teacher\Controller\IndependentWorkController',
            'Teacher\Controller\Module' => 'Teacher\Controller\ModuleController',
            'Teacher\Controller\ModuleType' => 'Teacher\Controller\ModuleTypeController',
            'Teacher\Controller\Room' => 'Teacher\Controller\RoomController',
            'Teacher\Controller\Student' => 'Teacher\Controller\StudentController',
            'Teacher\Controller\StudentGrade' => 'Teacher\Controller\StudentGradeController',
            'Teacher\Controller\StudentGroup' => 'Teacher\Controller\StudentGroupController',
            'Teacher\Controller\StudentInGroups' => 'Teacher\Controller\StudentInGroupsController',
            'Teacher\Controller\Subject' => 'Teacher\Controller\SubjectController',
            'Teacher\Controller\SubjectRound' => 'Teacher\Controller\SubjectRoundController',
            'Teacher\Controller\Teacher' => 'Teacher\Controller\TeacherController',
            'Teacher\Controller\Vocation' => 'Teacher\Controller\VocationController',
            'Teacher\Controller\LisUser' => 'Teacher\Controller\LisUserController',
        ],
    ],
    'router' => [
        'routes' => [
            'RestTeacher' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/teacher[/:controller][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Teacher\Controller',
                        'controller' => 'Teacher\Controller\Vocation',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];

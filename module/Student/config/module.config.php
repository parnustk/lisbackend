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
            'Student\Controller\Absence' => 'Student\Controller\AbsenceController',
            'Student\Controller\AbsenceReason' => 'Student\Controller\AbsenceReasonController',
            'Student\Controller\Administrator' => 'Student\Controller\AdministratorController',
            'Student\Controller\ContactLesson' => 'Student\Controller\ContactLessonController',
            'Student\Controller\GradeChoice' => 'Student\Controller\GradeChoiceController',
            'Student\Controller\GradingType' => 'Student\Controller\GradingTypeController',
            'Student\Controller\IndependentWork' => 'Student\Controller\IndependentWorkController',
            'Student\Controller\Module' => 'Student\Controller\ModuleController',
            'Student\Controller\ModuleType' => 'Student\Controller\ModuleTypeController',
            'Student\Controller\Room' => 'Student\Controller\RoomController',
            'Student\Controller\Student' => 'Student\Controller\StudentController',
            'Student\Controller\StudentGrade' => 'Student\Controller\StudentGradeController',
            'Student\Controller\StudentGroup' => 'Student\Controller\StudentGroupController',
            'Student\Controller\StudentInGroups' => 'Student\Controller\StudentInGroupsController',
            'Student\Controller\Subject' => 'Student\Controller\SubjectController',
            'Student\Controller\SubjectRound' => 'Student\Controller\SubjectRoundController',
            'Student\Controller\Teacher' => 'Student\Controller\TeacherController',
            'Student\Controller\Vocation' => 'Student\Controller\VocationController',
            'Student\Controller\LisUser' => 'Student\Controller\LisUserController'
        ],
    ],
    'router' => [
        'routes' => [
            'RestStudent' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/student[/:controller][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Student\Controller',
                        'controller' => 'Student\Controller\Vocation',
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

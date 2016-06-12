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
            'Administrator\Controller\Absence' => 'Administrator\Controller\AbsenceController',
            'Administrator\Controller\AbsenceReason' => 'Administrator\Controller\AbsenceReasonController',
            'Administrator\Controller\Administrator' => 'Administrator\Controller\AdministratorController',
            'Administrator\Controller\ContactLesson' => 'Administrator\Controller\ContactLessonController',
            'Administrator\Controller\GradeChoice' => 'Administrator\Controller\GradeChoiceController',
            'Administrator\Controller\GradingType' => 'Administrator\Controller\GradingTypeController',
            'Administrator\Controller\IndependentWork' => 'Administrator\Controller\IndependentWorkController',
            'Administrator\Controller\Module' => 'Administrator\Controller\ModuleController',
            'Administrator\Controller\ModuleType' => 'Administrator\Controller\ModuleTypeController',
            'Administrator\Controller\Room' => 'Administrator\Controller\RoomController',
            'Administrator\Controller\Student' => 'Administrator\Controller\StudentController',
            'Administrator\Controller\StudentGrade' => 'Administrator\Controller\StudentGradeController',
            'Administrator\Controller\StudentGroup' => 'Administrator\Controller\StudentGroupController',
            'Administrator\Controller\StudentInGroups' => 'Administrator\Controller\StudentInGroupsController',
            'Administrator\Controller\Subject' => 'Administrator\Controller\SubjectController',
            'Administrator\Controller\SubjectRound' => 'Administrator\Controller\SubjectRoundController',
            'Administrator\Controller\Teacher' => 'Administrator\Controller\TeacherController',
            'Administrator\Controller\Vocation' => 'Administrator\Controller\VocationController',
            'Administrator\Controller\LisUser' => 'Administrator\Controller\LisUserController',
        ],
        
    ],
    'router' => [
        'routes' => [
            'RestAdministrator' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin[/:controller][/:id]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Administrator\Controller',
                        'controller' => 'Administrator\Controller\Vocation',
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

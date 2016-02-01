/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

/**
 * 
 * @param {type} define
 * @returns {undefined}
 */
(function (define) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} config
     * @param {type} vocationModel
     * @param {type} gradingTypeModel
     * @param {type} teacherModel
     * @param {type} absencereasonModel
     * @param {type} vocationContoller
     * @param {type} gradingTypeController
     * @param {type} gradeChoiceController
     * @param {type} teacherContoller
     * @param {type} absencereasonContoller
     * @returns {unresolved}
     */
    define([
        'angular',
        'app/config',
        'app/model/vocationModel',
        'app/model/gradingTypeModel',
        'app/model/gradeChoiceModel',
        'app/model/teacherModel',
        'app/model/absencereasonModel',
        'app/model/roomModel',
        'app/controller/vocationContoller',
        'app/controller/gradingTypeController',
        'app/controller/gradeChoiceController',
        'app/controller/teacherContoller',
        'app/controller/absencereasonContoller',
        'app/controller/roomController'


    ], function (
            angular,
            config,
            vocationModel,
            gradingTypeModel,
            gradeChoiceModel,
            teacherModel,
            absencereasonModel,
            roomModel,
            vocationContoller,
            gradingTypeController,
            gradeChoiceController,
            teacherContoller,
            absencereasonContoller,
            roomController
            vocationContoller,
            moduleTypeModel,
            moduleTypeController
            ) {

        var adminModule = angular.module('adminModule', [
            'ngRoute',
            'ngResource',
            'ngTouch',
            'ui.grid',
            'ui.grid.edit',
            'ui.grid.cellNav',
            'ui.grid.saveState',
            'ui.grid.selection',
            'ui.grid.cellNav',
            'ui.grid.resizeColumns',
            'ui.grid.moveColumns',
            'ui.grid.pinning',
            'ui.grid.grouping'
        ]);

        adminModule.config(config);

        adminModule.factory('vocationModel', vocationModel);
        adminModule.factory('teacherModel', teacherModel);
        adminModule.factory('gradingTypeModel', gradingTypeModel);
        adminModule.factory('gradeChoiceModel', gradeChoiceModel);
        adminModule.factory('absencereasonModel', absencereasonModel);
        adminModule.factory('roomModel', roomModel);


        adminModule.controller('vocationController', vocationContoller);
        adminModule.controller('teacherController', teacherContoller);
        adminModule.controller('gradingTypeController', gradingTypeController);
        adminModule.controller('gradeChoiceController', gradeChoiceController);
        adminModule.controller('absencereasonController', absencereasonContoller);
        adminModule.controller('roomController', roomController);
        adminModule.factory('moduleTypeModel', moduleTypeModel);
        adminModule.controller('moduleTypeController', moduleTypeController);
        return adminModule;
    });

}(define));

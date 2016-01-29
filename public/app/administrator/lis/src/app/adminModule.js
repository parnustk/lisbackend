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
     * @param {type} teacherContoller
     * @param {type} absencereasonContoller
     * @returns {unresolved}
     */
    define([
        'angular',
        'app/config',
        'app/model/vocationModel',
        'app/model/gradingTypeModel',
        'app/model/teacherModel',
        'app/model/absencereasonModel',
        'app/controller/vocationContoller',
        'app/controller/gradingTypeController',
        'app/controller/teacherContoller',
        'app/controller/absencereasonContoller'

    ], function (
            angular,
            config,
            vocationModel,
            gradingTypeModel,
            teacherModel,
            absencereasonModel,
            vocationContoller,
            gradingTypeController,
            teacherContoller,
            absencereasonContoller
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
        adminModule.factory('absencereasonModel', absencereasonModel);
        
        adminModule.controller('vocationController', vocationContoller);
        adminModule.controller('teacherController', teacherContoller);
        adminModule.controller('gradingTypeController', gradingTypeController);
        adminModule.controller('absencereasonController', absencereasonContoller);

        return adminModule;
    });

}(define));

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

    define([
        'angular',
        'app/config',
        'app/model/vocationModel',
        'app/model/gradingTypeModel',
        'app/model/teacherModel',
        'app/controller/vocationContoller',
        'app/controller/gradingTypeController',
        'app/controller/teacherContoller'

    ], function (
        angular,
        config,
        vocationModel,
        gradingTypeModel,
        teacherModel,
        
        vocationContoller,
        gradingTypeController,
        teacherContoller
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

        adminModule.controller('vocationController', vocationContoller);
        adminModule.controller('teacherController', teacherContoller);
        adminModule.controller('gradingTypeController', gradingTypeController);

        return adminModule;
    });

}(define));
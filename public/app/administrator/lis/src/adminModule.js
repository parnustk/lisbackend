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
     * @param {type} teacherModel
     * @param {type} vocationContoller
     * @param {type} teacherContoller
     * @returns {angular.module.angular-1_3_6_L1749.moduleInstance}
     */
    define([
        'angular',
        'app/config',
        'app/model/vocationModel',
        'app/model/gradeChoiceModel',
        'app/model/teacherModel',
        'app/controller/vocationContoller',
        'app/controller/gradeChoiceController',
        'app/controller/teacherContoller'
    ], function (
        angular,
        config,
        vocationModel,
        gradeChoiceModel,
        teacherModel,
        vocationContoller,
        gradeChoiceController,
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
        adminModule.factory('gradeChoiceModel', gradeChoiceModel);


        adminModule.controller('vocationController', vocationContoller);
        adminModule.controller('teacherController', teacherContoller);
        adminModule.controller('gradeChoiceController', gradeChoiceController);

        return adminModule;
    });

}(define));

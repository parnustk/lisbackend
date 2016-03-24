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
        'app/model/gradeChoiceModel',
        'app/model/teacherModel',
        'app/model/absencereasonModel',
        'app/model/absenceModel',
        'app/model/roomModel',
        'app/model/moduletypeModel',
        'app/model/loginModel',
        'app/model/moduleModel',
        
        'app/controller/vocationController',
        'app/controller/gradingTypeController',
        'app/controller/gradeChoiceController',
        'app/controller/teacherController',
        'app/controller/absencereasonController',
        'app/controller/absenceController',
        'app/controller/roomController',
        'app/controller/moduletypeController',
        'app/controller/loginController',
        'app/controller/moduleController'
    ], function (
        angular,
        config,
        vocationModel,
        gradingTypeModel,
        gradeChoiceModel,
        teacherModel,
        absencereasonModel,
        absenceModel,
        roomModel,
        moduletypeModel,
        loginModel,
        moduleModel,
        vocationController,
        gradingTypeController,
        gradeChoiceController,
        teacherController,
        absencereasonController,
        absenceController,
        roomController,
        moduletypeController,
        loginController,
        moduleController
        ) {

        var adminModule = angular.module('adminModule', [
            'ngRoute',
            'ngResource',
            'ngTouch',
            'ui.grid',
            'ui.grid.cellNav',
            'ui.grid.rowEdit',
            'ui.grid.edit',
            'ui.grid.cellNav',
            'ui.grid.saveState',
            'ui.grid.selection',
            'ui.grid.resizeColumns',
            'ui.grid.moveColumns',
            'ui.grid.pinning',
            'ui.grid.grouping', 
            'ui.grid.exporter'
        ]);

        adminModule.config(config);

        adminModule.factory('vocationModel', vocationModel);
        adminModule.factory('teacherModel', teacherModel);
        adminModule.factory('gradingTypeModel', gradingTypeModel);
        adminModule.factory('gradeChoiceModel', gradeChoiceModel);
        adminModule.factory('absencereasonModel', absencereasonModel);
        adminModule.factory('absenceModel', absenceModel);
        adminModule.factory('roomModel', roomModel);
        adminModule.factory('moduletypeModel', moduletypeModel);
        adminModule.factory('loginModel', loginModel);
        adminModule.factory('moduleModel', moduleModel);

        adminModule.controller('vocationController', vocationController);
        adminModule.controller('teacherController', teacherController);
        adminModule.controller('gradingTypeController', gradingTypeController);
        adminModule.controller('gradeChoiceController', gradeChoiceController);
        adminModule.controller('absencereasonController', absencereasonController);
        adminModule.controller('absenceController', absenceController);
        adminModule.controller('roomController', roomController);
        adminModule.controller('moduletypeController', moduletypeController);
        adminModule.controller('loginController', loginController);
        adminModule.controller('moduleController', moduleController);

        return adminModule;
    });

}(define));

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
        'app/model/studentModel',
        'app/model/administratorModel',
        'app/model/subjectModel',
        'app/controller/vocationController',
        'app/controller/gradingTypeController',
        'app/controller/gradeChoiceController',
        'app/controller/teacherController',
        'app/controller/absencereasonController',
        'app/controller/absenceController',
        'app/controller/roomController',
        'app/controller/moduletypeController',
        'app/controller/loginController',
        'app/controller/moduleController',
        'app/controller/studentController',
        'app/controller/administratorController',
        'app/controller/subjectController'
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
        studentModel,
        administratorModel,
        subjectModel,
        vocationController,
        gradingTypeController,
        gradeChoiceController,
        teacherController,
        absencereasonController,
        absenceController,
        roomController,
        moduletypeController,
        loginController,
        moduleController,
        studentController,
        administratorController,
        subjectController
        ) {

        /**
         * http://codepen.io/transistor1/pen/wGvMEE
         * https://github.com/angular-ui/ui-grid/issues/5173
         */
        angular.module('gridFilters', []).filter('griddropdown', function () {
            return function (input, context) {
//                function hasOwnProperty(obj, prop) {
//                    var proto = obj.__proto__ || obj.constructor.prototype;
//                    return (prop in obj) &&
//                        (!(prop in proto) || proto[prop] !== obj[prop]);
//                }
                try {
                    //For some reason the text "this" is occasionally directly beingpassed here
                    if (typeof context === 'undefined' || context === 'this') {
                        return 0;
                    }

                    //Workaround for bug in ui-grid
                    if (typeof context.col === 'undefined') {
                        var sortCols = context.grid.getColumnSorting();
                        if (sortCols.length <= 0) {
                            return 0;
                        }
                        context = {col: sortCols[0], row: context};
                    }

                    var map,
                        colDef = context.col.colDef,
                        idField = colDef.editDropdownIdLabel,
                        valueField = colDef.editDropdownValueLabel,
                        initial = context.row.entity[context.col.field],
                        result;

                    if (typeof colDef.editDropdownOptionsArray !== 'undefined') {
                        map = colDef.editDropdownOptionsArray;
                    } else {
                        map = colDef.editDropdownOptionsFunction();
                    }

                    if (parseInt(input) !== input) {
                        input = input.id;
                    }
                    if (typeof map !== "undefined") {
                        for (var i = 0; i < map.length; i++) {
                            if (map[i][idField] === input) {
                                result = map[i][valueField];//console.log('found match');
                                break;
                            }
                        }
                    } else if (initial) {
                        result = initial;//console.log('initial exists');
                    } else {
                        
                        result = input;//console.log('input stays');
                    }
                    
                    return result;
                } catch (e) {
                    context.grid.appScope.log("Error: " + e);
                }
            };
        });

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
            'ui.grid.exporter',
            'gridFilters',
            'ui.select'
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
        adminModule.factory('studentModel', studentModel);
        adminModule.factory('administratorModel', administratorModel);
        adminModule.factory('subjectModel', subjectModel);

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
        adminModule.controller('studentController', studentController);
        adminModule.controller('administratorController', administratorController);
        adminModule.controller('subjectController', subjectController);

        adminModule.directive('uiSelectWrap', uiSelectWrap);

        uiSelectWrap.$inject = ['$document', 'uiGridEditConstants'];
        
        function uiSelectWrap($document, uiGridEditConstants) {
            return function link($scope, $elm, $attr) {
                $document.on('click', docClick);
                function docClick(evt) {
                    if ($(evt.target).closest('.ui-select-container').size() === 0) {
                        $scope.$emit(uiGridEditConstants.events.END_CELL_EDIT);
                        $document.off('click', docClick);
                    }
                }
            };
        }

        return adminModule;
    });

}(define));

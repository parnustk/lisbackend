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
        'app/model/absenceReasonModel',
        'app/model/absenceModel',
        'app/model/roomModel',
        'app/model/moduletypeModel',
        'app/model/loginModel',
        'app/model/moduleModel',
        'app/model/studentModel',
        'app/model/administratorModel',
        'app/model/subjectModel',
        'app/model/contactLessonModel',
        'app/controller/vocationController',
        'app/controller/gradingTypeController',
        'app/controller/gradeChoiceController',
        'app/controller/teacherController',
        'app/controller/absenceReasonController',
        'app/controller/absenceController',
        'app/controller/roomController',
        'app/controller/moduletypeController',
        'app/controller/loginController',
        'app/controller/moduleController',
        'app/controller/studentController',
        'app/controller/administratorController',
        'app/controller/subjectController',
        'app/controller/contactLessonController'
    ], function (
        angular,
        config,
        vocationModel,
        gradingTypeModel,
        gradeChoiceModel,
        teacherModel,
        absenceReasonModel,
        absenceModel,
        roomModel,
        moduletypeModel,
        loginModel,
        moduleModel,
        studentModel,
        administratorModel,
        subjectModel,
        contactLessonModel,
        vocationController,
        gradingTypeController,
        gradeChoiceController,
        teacherController,
        absenceReasonController,
        absenceController,
        roomController,
        moduletypeController,
        loginController,
        moduleController,
        studentController,
        administratorController,
        subjectController,
        contactLessonController
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
                    console.log("Error: " + e);
                    //context.grid.appScope.log("Error: " + e);
                    context.grid.appScope.log("Error: " + e);
                }
            };
        });

        var adminModule = angular.module('adminModule', [
            'ngRoute',
            'ngResource',
            'ngTouch',
            'ngSanitize',
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

        adminModule.directive('uiSelectRequired', function () {
            return {
                require: 'ngModel',
                link: function (scope, element, attr, ctrl) {
                    ctrl.$validators.uiSelectRequired = function (modelValue, viewValue) {
                        if (attr.uiSelectRequired) {
                            var isRequired = scope.$eval(attr.uiSelectRequired);
                            if (isRequired === false) {
                                return true;
                            }
                        }
                        var determineVal;
                        if (angular.isArray(modelValue)) {
                            determineVal = modelValue;
                        } else if (angular.isArray(viewValue)) {
                            determineVal = viewValue;
                        } else {
                            return false;
                        }
                        return determineVal.length > 0;
                    };
                }
            };
        });

        /**
         * UI select
         * AngularJS default filter with the following expression:
         * "person in people | filter: {name: $select.search, age: $select.search}"
         * performs a AND between 'name: $select.search' and 'age: $select.search'.
         * We want to perform a OR.
         */
        adminModule.filter('propsFilter', function () {
            return function (items, props) {
                var out = [];
                if (angular.isArray(items)) {
                    items.forEach(function (item) {
                        var itemMatches = false;
                        var keys = Object.keys(props);
                        for (var i = 0; i < keys.length; i++) {
                            var prop = keys[i];
                            var text = props[prop].toLowerCase();
                            if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                                itemMatches = true;
                                break;
                            }
                        }
                        if (itemMatches) {
                            out.push(item);
                        }
                    });
                } else {
                    out = items;// Let the output be the input untouched
                }
                return out;
            };
        });

        //Here we start with our Business Logic itself
        adminModule.factory('vocationModel', vocationModel);
        adminModule.factory('teacherModel', teacherModel);
        adminModule.factory('gradingTypeModel', gradingTypeModel);
        adminModule.factory('gradeChoiceModel', gradeChoiceModel);
        adminModule.factory('absenceReasonModel', absenceReasonModel);
        adminModule.factory('absenceModel', absenceModel);
        adminModule.factory('roomModel', roomModel);
        adminModule.factory('moduletypeModel', moduletypeModel);
        adminModule.factory('loginModel', loginModel);
        adminModule.factory('moduleModel', moduleModel);
        adminModule.factory('studentModel', studentModel);
        adminModule.factory('administratorModel', administratorModel);
        adminModule.factory('subjectModel', subjectModel);
        adminModule.factory('contactLessonModel', contactLessonModel);

        adminModule.controller('vocationController', vocationController);
        adminModule.controller('teacherController', teacherController);
        adminModule.controller('gradingTypeController', gradingTypeController);
        adminModule.controller('gradeChoiceController', gradeChoiceController);
        adminModule.controller('absenceReasonController', absenceReasonController);
        adminModule.controller('absenceController', absenceController);
        adminModule.controller('roomController', roomController);
        adminModule.controller('moduletypeController', moduletypeController);
        adminModule.controller('loginController', loginController);
        adminModule.controller('moduleController', moduleController);
        adminModule.controller('studentController', studentController);
        adminModule.controller('administratorController', administratorController);
        adminModule.controller('subjectController', subjectController);
        adminModule.controller('contactLessonController', contactLessonController);

        return adminModule;
    });

}(define));

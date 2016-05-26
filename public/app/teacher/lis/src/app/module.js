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
        /*1*/'angular',
        /*2*/'app/config',
        /*1*/'app/model/vocationModel',
        /*2*/'app/model/gradingTypeModel',
        /*3*/'app/model/gradeChoiceModel',
        /*4*/'app/model/teacherModel',
        /*5*/'app/model/absenceReasonModel',
        /*6*/'app/model/absenceModel',
        /*7*/'app/model/roomModel',
        /*8*/'app/model/moduleTypeModel',
        /*9*/'app/model/loginModel',
        /*10*/'app/model/moduleModel',
        /*11*/'app/model/studentModel',
        /*12*/'app/model/administratorModel',
        /*13*/'app/model/subjectModel',
        /*14*/'app/model/contactLessonModel',
        /*15*/'app/model/subjectRoundModel',
        /*16*/'app/model/studentGroupModel',
        /*17*/'app/model/independentWorkModel',
        /*18*/'app/model/studentGradeModel',
        /*19*/'app/model/studentInGroupsModel',
        /*20*/'app/model/registerModel',
        /*1*/'app/controller/loginController',
        /*2*/'app/controller/diaryController',
        /*17*/'app/controller/independentWorkController'
    ], function (
        /*1*/angular,
        /*2*/config,
        /*1*/vocationModel,
        /*2*/gradingTypeModel,
        /*3*/gradeChoiceModel,
        /*4*/teacherModel,
        /*5*/absenceReasonModel,
        /*6*/absenceModel,
        /*7*/roomModel,
        /*8*/moduleTypeModel,
        /*9*/loginModel,
        /*10*/moduleModel,
        /*11*/studentModel,
        /*12*/administratorModel,
        /*13*/subjectModel,
        /*14*/contactLessonModel,
        /*15*/subjectRoundModel,
        /*16*/studentGroupModel,
        /*17*/independentWorkModel,
        /*18*/studentGradeModel,
        /*19*/studentInGroupsModel,
        /*20*/registerModel,
        /*1*/loginController,
        /*2*/diaryController,
        /*17*/independentWorkController
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
                        if (!!input) {
                            input = input.id;
                        } else {
                            return null;
                        }
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

        var module = angular.module('module', [
            'ngRoute',
            'ngResource',
            'ngTouch',
            'ngAnimate',
            'ngSanitize',
            'ngCookies',
            'ui.bootstrap',
            'ui.grid',
            'ui.grid.pinning',
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

        module.config(config);

        module.directive('uiSelectWrap', uiSelectWrap);

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

        module.directive('uiSelectRequired', function () {
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

        module.directive('datepickerPopup', function () {
            /* http://stackoverflow.com/questions/24198669/angular-bootsrap-datepicker-date-format-does-not-format-ng-model-value */
            return {
                restrict: 'EAC',
                require: 'ngModel',
                link: function (scope, element, attr, controller) {
                    //remove the default formatter from the input directive to prevent conflict
                    controller.$formatters.shift();
                }
            };
        });

        var compareTo = function () {
            return {
                require: "ngModel",
                scope: {
                    otherModelValue: "=compareTo"
                },
                link: function (scope, element, attributes, ngModel) {

                    ngModel.$validators.compareTo = function (modelValue) {
                        return modelValue === scope.otherModelValue;
                    };

                    scope.$watch("otherModelValue", function () {
                        ngModel.$validate();
                    });
                }
            };
        };

        module.directive("compareTo", compareTo);

        /**
         * UI select
         * AngularJS default filter with the following expression:
         * "person in people | filter: {name: $select.search, age: $select.search}"
         * performs a AND between 'name: $select.search' and 'age: $select.search'.
         * We want to perform a OR.
         */
        module.filter('propsFilter', function () {
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
        module.factory('vocationModel', vocationModel);
        module.factory('teacherModel', teacherModel);
        module.factory('gradingTypeModel', gradingTypeModel);
        module.factory('gradeChoiceModel', gradeChoiceModel);
        module.factory('absenceReasonModel', absenceReasonModel);
        module.factory('absenceModel', absenceModel);
        module.factory('roomModel', roomModel);
        module.factory('moduleTypeModel', moduleTypeModel);
        module.factory('loginModel', loginModel);
        module.factory('moduleModel', moduleModel);
        module.factory('studentModel', studentModel);
        module.factory('administratorModel', administratorModel);
        module.factory('subjectModel', subjectModel);
        module.factory('contactLessonModel', contactLessonModel);
        module.factory('studentGroupModel', studentGroupModel);
        module.factory('independentWorkModel', independentWorkModel);
        module.factory('subjectRoundModel', subjectRoundModel);
        module.factory('studentGradeModel', studentGradeModel);
        module.factory('studentInGroupsModel', studentInGroupsModel);
        module.factory('registerModel', registerModel);


        module.controller('loginController', loginController);
        module.controller('diaryController', diaryController);
        module.controller('independentWorkController', independentWorkController);

        return module;
    });

}(define));

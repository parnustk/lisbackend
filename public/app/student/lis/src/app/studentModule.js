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
        /*21*/'app/model/lisUserModel',
        /*1*/'app/controller/loginController',
        /*2*/'app/controller/timeTableController',
        /*6*/'app/controller/absenceController',
        /*14*/'app/controller/contactLessonGradeController',
        /*15*/'app/controller/subjectRoundGradeController',
        /*18*/'app/controller/studentGradeController',
        /*19*/'app/controller/homeController',
        /*22*/'app/controller/userDataController'
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
        /*21*/lisUserModel,
        /*1*/loginController,
        /*2*/timeTableController,
        /*6*/absenceController,
        /*14*/contactLessonGradeController,
        /*15*/subjectRoundGradeController,
        /*18*/studentGradeController,
        /*19*/homeController,
        /*22*/userDataController
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

        var studentModule = angular.module('studentModule', [
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

        studentModule.config(config);

        studentModule.directive('uiSelectWrap', uiSelectWrap);

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

        studentModule.directive('uiSelectRequired', function () {
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

        studentModule.directive('datepickerPopup', function () {
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

        studentModule.directive("compareTo", compareTo);

        /**
         * UI select
         * AngularJS default filter with the following expression:
         * "person in people | filter: {name: $select.search, age: $select.search}"
         * performs a AND between 'name: $select.search' and 'age: $select.search'.
         * We want to perform a OR.
         */
        studentModule.filter('propsFilter', function () {
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

        studentModule.factory('gradeService', function () {
            var _grades = [],
                gradeService = {};

            gradeService.fill = function (grades) {
                _grades = grades;
            };

            gradeService.list = function () {
                return _grades;
            };

            gradeService.clear = function () {
                _grades.length = 0;
            };

            return gradeService;
        });

        //Here we start with our Business Logic itself
        studentModule.factory('vocationModel', vocationModel);
        studentModule.factory('teacherModel', teacherModel);
        studentModule.factory('gradingTypeModel', gradingTypeModel);
        studentModule.factory('gradeChoiceModel', gradeChoiceModel);
        studentModule.factory('absenceReasonModel', absenceReasonModel);
        studentModule.factory('absenceModel', absenceModel);
        studentModule.factory('roomModel', roomModel);
        studentModule.factory('moduleTypeModel', moduleTypeModel);
        studentModule.factory('loginModel', loginModel);
        studentModule.factory('moduleModel', moduleModel);
        studentModule.factory('studentModel', studentModel);
        studentModule.factory('administratorModel', administratorModel);
        studentModule.factory('subjectModel', subjectModel);
        studentModule.factory('contactLessonModel', contactLessonModel);
        studentModule.factory('studentGroupModel', studentGroupModel);
        studentModule.factory('independentWorkModel', independentWorkModel);
        studentModule.factory('subjectRoundModel', subjectRoundModel);
        studentModule.factory('studentGradeModel', studentGradeModel);
        studentModule.factory('studentInGroupsModel', studentInGroupsModel);
        studentModule.factory('registerModel', registerModel);
        studentModule.factory('lisUserModel', lisUserModel);


        studentModule.controller('loginController', loginController);
        studentModule.controller('timeTableController', timeTableController);
        studentModule.controller('absenceController', absenceController);
        studentModule.controller('contactLessonGradeController', contactLessonGradeController);
        studentModule.controller('subjectRoundGradeController', subjectRoundGradeController);
        studentModule.controller('studentGradeController', studentGradeController);
        studentModule.controller('homeController', homeController);
        studentModule.controller('userDataController', userDataController);


        return studentModule;
    });

}(define));

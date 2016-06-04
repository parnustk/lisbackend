/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */

/* global define */

/**
 * 
 * @param {type} window
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (window, define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @param {type} moment
     * @returns {contactLessonGradeController_L30.contactLessonGradeController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                contactLessonGradeController.$inject = [
                    '$filter',
                    '$location',
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'contactLessonModel',
                    'independentWorkModel',
                    'roomModel',
                    'subjectRoundModel',
                    'studentGroupModel',
                    'moduleModel',
                    'vocationModel',
                    'teacherModel',
                    'gradeService'
                ];

                function contactLessonGradeController(
                        $filter,
                        $location,
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        contactLessonModel,
                        independentWorkModel,
                        roomModel,
                        subjectRoundModel,
                        studentGroupModel,
                        moduleModel,
                        vocationModel,
                        teacherModel,
                        gradeService) {

                    $scope.T = globalFunctions.T;

                    $scope.dt = {};

                    //START datepicker

                    $scope.today = function () {
                        $scope.dt = new Date();
                    };
                    $scope.today();

                    $scope.clear = function () {
                        $scope.dt = null;
                    };

                    $scope.inlineOptions = {
                        customClass: getDayClass,
                        minDate: new Date(),
                        showWeeks: true
                    };

                    $scope.dateOptions = {
                        dateDisabled: disabled,
                        formatYear: 'yy',
                        maxDate: new Date(2020, 5, 22),
                        minDate: new Date(),
                        startingDay: 1
                    };

                    // Disable weekend selection
                    function disabled(data) {
                        var date = data.date,
                                mode = data.mode;
                        return mode === 'day' && (date.getDay() === 0 /*|| date.getDay() === 6*/);
                    }

                    $scope.toggleMin = function () {
                        $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
                        $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
                    };

                    $scope.toggleMin();

                    $scope.open1 = function () {
                        $scope.popup1.opened = true;
                    };

                    $scope.open2 = function () {
                        $scope.popup2.opened = true;
                    };

                    $scope.setDate = function (year, month, day) {
                        $scope.dt = new Date(year, month, day);
                    };

                    $scope.formats = ['dd.MM.yyyy', 'dd-MMMM-yyyy', 'yyyy/MM/dd', 'shortDate'];
                    $scope.format = $scope.formats[0];
                    $scope.altInputFormats = ['M!/d!/yyyy'];

                    $scope.popup1 = {
                        opened: false
                    };

                    $scope.popup2 = {
                        opened: false
                    };

                    var tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    var afterTomorrow = new Date();
                    afterTomorrow.setDate(tomorrow.getDate() + 1);
                    $scope.events = [
                        {
                            date: tomorrow,
                            status: 'full'
                        },
                        {
                            date: afterTomorrow,
                            status: 'partially'
                        }
                    ];

                    function getDayClass(data) {
                        var date = data.date,
                                mode = data.mode;
                        if (mode === 'day') {
                            var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                            for (var i = 0; i < $scope.events.length; i++) {
                                var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                                if (dayToCheck === currentDay) {
                                    return $scope.events[i].status;
                                }
                            }
                        }

                        return '';
                    }

                    $scope.goBack = function () {
                        window.history.back();
                    };

                    $scope.FormatDate = function (ds) {
                        var dFinal;

                        if (window.LisGlobals.L === 'et') {
                            dFinal = moment(ds).format('DD.MM.YYYY');
                        } else {
                            dFinal = moment(ds).format('DD/MM/YYYY');
                        }
                        return dFinal;
                    };

                    var moduleId = $routeParams.moduleId,
                            subjectRoundId = $routeParams.subjectRoundId,
                            allGrades = gradeService.list();

                    if (allGrades.length === 0) {
                        $location.path("/");
                    } else {
                        $scope.subjectRoundName = allGrades[0].name;
                    }

                    $scope.contactLessons = $scope.independentWorks = $scope.modules= [];

                    $scope.studentGradeFilter = {};


                    for (var x in allGrades) {

                        if (allGrades[x].id === moduleId) {
                            var subjectRoundGrades = allGrades[x].subjectRound;

                            for (var y in subjectRoundGrades) {
                                if (subjectRoundGrades[y].id === subjectRoundId) {

                                    $scope.contactLessons = subjectRoundGrades[y].contactLesson;
                                    $scope.independentWorks = subjectRoundGrades[y].independentWork;

                                    break;
                                }
                            }

                            break;
                        }
                    }

//                    var urlParams = {
//                        page: 1,
//                        limit: 100000,
//                        studentModuleGrades: true
//                    };
//
//                    var resetUrlParams = function () {
//                        urlParams = {
//                            page: 1,
//                            limit: 100000,
//                            studentModuleGrades: true
//                        };
//                    };
//
//                    /**
//                     * Remove criteria
//                     * 
//                     * @returns {undefined}
//                     */
//                    $scope.ClearFilters = function () {
//                        resetUrlParams();
//                        $scope.studentAbsenceFilter = {};
//                        delete urlParams.where;
//                        LoadData();
//                    };
                    
//                    /**
//                 * 
//                 * @param {type} valid
//                 * @returns {undefined}
//                 */
//                $scope.Filter = function (valid) {
//                    resetUrlParams();
//                    if (valid) {
//                        urlParams.startDateIW = moment($scope.studentGradeFilter.startDateIW).format('YYYY-MM-DD');
//                        urlParams.endDateIW = moment($scope.studentGradeFilter.endDateIW).format('YYYY-MM-DD');
//                        LoadData();
//
//                    } else {
//                        alert('error');
//                    }
//                };
//                
//                $scope.dateFilter = function (items, startDateIW, endDateIW) {
//                    startDateIW = parseDate(startDateIW);
//                    endDateIW = parseDate(endDateIW);
//                    var result = [];
//                    for (var i = 0; i < items.length; i++) {
//                        var searchStartDate = new Date(),
//                            searchEndDate = new Date(items[i].date2 * 1000);
//                        if (searchStartDate > startDateIW && searchEndDate < endDateIW) {
//                            result.push(items[i]);
//                        }
//                    }
//                    return result;
//                };

//                    /**
//                     * 
//                     * @returns {undefined}
//                     */
//                    function LoadData() {
//                        moduleModel.GetList(urlParams).then(function (result) {
//                             if (globalFunctions.resultHandler(result)) {
//                                $scope.modules = result.data;
//                            }
//                        });
//                    }

//                    console.log('contact', $scope.contactLessons);
//                    console.log('independentWorks', $scope.independentWorks);

                }//class ends

                return contactLessonGradeController;
            });

}(window, define, document));
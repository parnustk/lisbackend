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
     * @returns {absenceController_L24.absenceController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                absenceController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'absenceModel',
                    'absenceReasonModel',
                    'studentModel',
                    'contactLessonModel',
                    'subjectRoundModel',
                    'teacherModel',
                    'roomModel'
                ];

                /**
                 * 
                 * @param {type} $scope
                 * @param {type} $q
                 * @param {type} $routeParams
                 * @param {type} rowSorter
                 * @param {type} uiGridConstants
                 * @param {type} absenceModel
                 * @param {type} absenceReasonModel
                 * @param {type} studentModel
                 * @param {type} contactLessonModel
                 * @param {type} subjectRoundModel
                 * @param {type} teacherModel
                 * @param {type} roomModel
                 * @returns {absenceController_L28.absenceController}
                 */
                function absenceController(
                        $scope,
                        $q,
                        $routeParams,
                        rowSorter,
                        uiGridConstants,
                        absenceModel,
                        absenceReasonModel,
                        studentModel,
                        contactLessonModel,
                        subjectRoundModel,
                        teacherModel,
                        roomModel
                        ) {

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


                    /**
                     * Remove criteria
                     * 
                     * @returns {undefined}
                     */
                    $scope.ClearFilters = function () {
                        resetUrlParams();
                        $scope.studentTimeTableFilter = {};
                        delete urlParams.where;
                        LoadData();
                    };

                    /**
                     * For filters and maybe later pagination
                     * 
                     * @type type
                     */
                    var urlParams = {
                        page: 1,
                        limit: 100000,
                        studentTimeTable: true
                    };

                    var resetUrlParams = function () {
                        urlParams = {
                            page: 1,
                            limit: 100000,
                            studentTimeTable: true
                        };
                    };

                    $scope.studentTimeTableFilter = {};

                    $scope.contactLessons = $scope.absenceReasons = $scope.subjectRounds = $scope.teachers = $scope.rooms = [];

                    $scope.FormatDate = function (ds) {

                        var dObj = new Date(ds),
                                dFinal;

                        if (window.LisGlobals.L === 'et') {
                            dFinal = moment(dObj).format('DD.MM.YYYY');
                        } else {
                            dFinal = moment(dObj).format('DD/MM/YYYY');
                        }
                        return dFinal;
                    };

                    /**
                     * 
                     * @param {type} valid
                     * @returns {undefined}
                     */
                    $scope.Filter = function (valid) {
                        resetUrlParams();
                        if (valid) {
//                            console.log(moment($scope.studentAbsenceFilter.startDate).format('YYYY-MM-DD'));
//                            console.log(moment($scope.studentAbsenceFilter.endDate).format('YYYY-MM-DD'));
                            urlParams.startDate = moment($scope.studentTimeTableFilter.startDate).format('YYYY-MM-DD');
                            urlParams.endDate = moment($scope.studentTimeTableFilter.endDate).format('YYYY-MM-DD');
                            LoadData();

                        } else {
                            alert('error');
                        }
                    };

                    $scope.dateFilter = function (items, startDate, endDate) {
                        var startDate = parseDate(startDate);
                        var endDate = parseDate(endDate);
                        var result = [];
                        for (var i = 0; i < items.length; i++) {
                            var searchStartDate = new Date(),
                                    searchEndDate = new Date(items[i].date2 * 1000);
                            if (searchStartDate > startDate && searchEndDate < endDate) {
                                result.push(items[i]);
                            }
                        }
                        return result;
                    };

                    /**
                     * 
                     * @returns {undefined}
                     */
                    function LoadData() {
                        subjectRoundModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.subjectRounds = result.data;
                            }
                        });
                    }

                    LoadData();//let's start loading data
                }

                return absenceController;
            });

}(window, define, document));
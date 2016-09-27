/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */

/* global define */

(function (window, define, document) {
    'use strict';

    define(['angular', 'app/util/globalFunctions'],
            function (angular, globalFunctions) {
                lessonReportController.$inject = [
                    '$scope',
                    '$q',
                    '$routeParams',
                    'rowSorter',
                    'uiGridConstants',
                    'lessonReportModel',
                    'contactLessonModel',
                    'teacherModel'
                ];

                /**
                 *
                 * @param $scope
                 * @param $q
                 * @param $routeparams
                 * @param rowSorter
                 * @param uiGridConstants
                 * @param lessonReportModel
                 * @param contactLessonModel
                 * @param teacherModel
                 */
                function lessonReportController($scope,
                        $q,
                        $routeparams,
                        rowSorter,
                        uiGridConstants,
                        lessonReportModel,
                        contactLessonModel,
                        teacherModel) {

                    $scope.T = globalFunctions.T;

                    /**
                     *
                     * @type {{page: number, limit: number, lessonReport: string, teacherId: null}}
                     */
                    var urlParams = {
                        page: 1,
                        limit: 1000,
                        lessonReport: 'lessonReport',
                        teacherId: null,
                        startDate: null,
                        endDate: null
                    };


                    $scope.lessonReportFilter = {};
                    $scope.lessonReports = [];
                    $scope.contactLessons = [];
                    $scope.teachers = [];

                    $scope.popup1 = {
                        opened: false
                    };

                    $scope.popup2 = {
                        opened: false
                    };

                    $scope.open1 = function () {
                        $scope.popup1.opened = true;
                    };

                    $scope.open2 = function () {
                        $scope.popup2.opened = true;
                    };

                    $scope.dateOptions = {
                        maxDate: new Date(2020, 5, 22),
                        minDate: new Date(1900, 1, 1)
                    };


                    teacherModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.teachers = result.data;
                        }
                    });
                    //you have to get at least teacherId into urlParams
                    //if no teacherId then filterForm is invalid
                    //3 fields required filter is teacherId, optional filters are startDate and endDate

                    /**
                     * rearranges data in the object, so that it can be easily displayed using angular
                     * angular can read from contactLessons[i], but most of the data is in contactLessons[i][0]
                     */
                    function fixData() {
                        var objectLength = Object.keys($scope.contactLessons).length;

                        var i = 0;
                        while (i < objectLength) {
                            $scope.contactLessons[i].id = $scope.contactLessons[i][0].id;
                            $scope.contactLessons[i].lessonDate = $scope.contactLessons[i][0].lessonDate;
                            $scope.contactLessons[i].teacher = $scope.contactLessons[i][0].teacher;
                            $scope.contactLessons[i].subjectRound = $scope.contactLessons[i][0].subjectRound;
                            $scope.contactLessons[i].studentGroup = $scope.contactLessons[i][0].studentGroup;
                            $scope.contactLessons[i].rooms = $scope.contactLessons[i][0].rooms;
                            i++;
                        }
                    }


                    $scope.Filter = function () {

                        if (!angular.equals({}, $scope.items)) {
                            if ($scope.lessonReportFilter.teacher !== undefined) {
                                urlParams.teacherId = $scope.lessonReportFilter.teacher.id;
                                urlParams.startDate = $scope.lessonReportFilter.startDate;

                                var fixedDate = $scope.lessonReportFilter.endDate;
                                if (fixedDate) {
                                    fixedDate.setDate(fixedDate.getDate() + 1);
                                }

                                urlParams.endDate = fixedDate;
                                urlParams.where = angular.toJson(globalFunctions.cleanData($scope.lessonReportFilter));
                                LoadData();

                            } else {
                                console.log('No teacher selected');
                            }
                        }
                    };

                    $scope.ClearFilters = function () {
                        resetUrlParams();
                        $scope.lessonReportFilter = {};
                        delete urlParams.where;
                    };

                    var resetUrlParams = function () {
                        urlParams = {
                            page: 1,
                            limit: 1000,
                            lessonReport: 'lessonReport',
                            teacherId: null,
                            startDate: null,
                            endDate: null
                        };
                    };

                    /**
                     *
                     * @constructor
                     */
                    function LoadData() {
                        contactLessonModel.GetList(urlParams).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.contactLessons = result.data;
                                fixData();
                            }
                        });
                    }
                }

                return lessonReportController;
            });
}(window, define, document));
/* global define */

/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 * @author Alar Aasa <alar@alaraasa.ee>
 */

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
               'contactLessonModel'
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
             */
            function lessonReportController(
                $scope,
                $q,
                $routeparams,
                rowSorter,
                uiGridConstants,
                lessonReportModel,
                contactLessonModel
            ) {

            $scope.T = globalFunctions.T;

                /**
                 *
                 * @type {{page: number, limit: number}}
                 */
                var urlParams = {
                    page: 1,
                    limit: 1000,
                    lessonReport: 'lessonReport'
                };


                $scope.filterLessonReport = {};
                $scope.lessonReports = [];
                $scope.contactLessons = [];
                
                //you have to get at least teacherId into urlParams
                //if no teacherId then filterForm is invalid
                //3 fields required filter is teacherId, optional filters are startDate and endDate
                $scope.Filter = function () {
                  if (!angular.equals({}, $scope.items)) {
                      urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterLessonReport));
                      LoadData();
                  }
                };
                /**
                 *
                 * @constructor
                 */
                function LoadData() {
                    contactLessonModel.GetList(urlParams).then(function (result) {
                       if (globalFunctions.resultHandler(result)) {
                           $scope.contactLessons = result.data;
                       }
                    });
                }
            }

            return lessonReportController;
        });
}(window, define, document));
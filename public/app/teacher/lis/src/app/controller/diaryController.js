/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

/**
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    define(['angular', 'app/util/globalFunctions', 'moment'],
        function (angular, globalFunctions, moment) {

            diaryController.$inject = [
                '$scope',
                '$q',
                '$routeParams',
                'rowSorter',
                'uiGridConstants',
                'contactLessonModel',
                'roomModel',
                'subjectRoundModel',
                'studentGroupModel',
                'moduleModel',
                'vocationModel',
                'teacherModel'
            ];

            function diaryController(
                $scope,
                $q,
                $routeParams,
                rowSorter,
                uiGridConstants,
                contactLessonModel,
                roomModel,
                subjectRoundModel,
                studentGroupModel,
                moduleModel,
                vocationModel,
                teacherModel) {

                $scope.T = globalFunctions.T;

                var urlParams = {
                    page: 1,
                    limit: 1000,
                    diaryview: 1
                };

                var rawData = null;

                $scope.diaryFilter = {};

                $scope.subjectRounds = $scope.studentGroups = [];

                subjectRoundModel.GetList({}).then(function (result) {
                    if (globalFunctions.resultHandler(result)) {
                        $scope.subjectRounds = result.data;

                        studentGroupModel.GetList({}).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.studentGroups = result.data;

                            }
                        });
                    }
                });

                var resetUrlParams = function () {
                    urlParams = {
                        page: 1,
                        limit: 1000,
                        diaryview: 1
                    };
                };

                $scope.Filter = function () {
                    resetUrlParams();
                    var data = globalFunctions.cleanData($scope.diaryFilter);
                    urlParams.where = angular.toJson(data);
                    getData();
                };

                var getData = function () {
                    subjectRoundModel.GetList(urlParams).then(function (result) {
                        console.log(result);
                        if (globalFunctions.resultHandler(result)) {

                        }
                    });
                };

            }

            return diaryController;
        });

}(define, document));

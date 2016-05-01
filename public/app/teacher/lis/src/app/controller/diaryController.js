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

                var urlParamsStudentGroup = {
                    page: 1,
                    limit: 1000,
                    diaryview: 1
                };
                
                var urlParamsSubjectRound = {
                    page: 1,
                    limit: 1000,
                    diaryview: 1
                };

                var rawDataStudentGroup = null, rawDataSubjectRound = null;

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
                    
                    urlParamsStudentGroup = {
                        page: 1,
                        limit: 1000,
                        diaryview: 'diaryview'
                    };
                    
                    urlParamsSubjectRound = {
                        page: 1,
                        limit: 1000,
                        diaryview: 'diaryview'
                    };
                };

                /**
                 * Set up StudentGroup as param SubkectRound
                 * @returns {undefined}
                 */
                $scope.Filter = function () {
                    resetUrlParams();
                    var data = globalFunctions.cleanData($scope.diaryFilter);
                    urlParamsSubjectRound.where = angular.toJson(data);
                    getData();
                };

                /**
                 * We get student related data from by StudentGroup related req, has default params
                 * Grade related data we get by SubjectRound req has params by StudentGroup.
                 * 
                 * @returns {undefined}
                 */
                var getData = function () {
                    subjectRoundModel.GetList(urlParamsSubjectRound).then(function (result) {
                        console.log(result);
                        if (globalFunctions.resultHandler(result)) {
                            rawDataSubjectRound = result.data;
                            console.log('RAW rawDataSubjectRound', rawDataSubjectRound);
                        }
                    });
                    
                    studentGroupModel.GetList(urlParamsSubjectRound).then(function (result) {
                        console.log(result);
                        if (globalFunctions.resultHandler(result)) {
                            rawDataStudentGroup = result.data;
                            console.log('rawDataSubjectRound', rawDataSubjectRound);
                        }
                    });
                };

            }

            return diaryController;
        });

}(define, document));

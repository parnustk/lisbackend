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
                        if (globalFunctions.resultHandler(result)) {
                            rawDataSubjectRound = result.data;
                            //console.log('RAW rawDataSubjectRound', rawDataSubjectRound);

                            studentGroupModel.GetList(urlParamsSubjectRound).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    rawDataStudentGroup = result.data;
                                    //console.log('rawDataSubjectRound', rawDataSubjectRound);
                                    sortDataForDiary();
                                }
                            });

                        }
                    });
                };

                $scope.Sort = function () {
                    sortDataForDiary();
                };

                var columns = [], //array of elements
                    rows = [];//array of arrays of elements

                var teacherId = 1;//comes from session LisPerson
                
                var sortDataForDiary = function () {
                    columns = [];//tmp
                    rows = [];//tmp

                    //rows 
                    var students = rawDataStudentGroup[0].studentInGroups;
                    for (var y in students) {
                        var row = [];
                        console.log(students[y].student);
                        row.push({
                            id: students[y].student.id,
                            name: students[y].student.name});
                        rows.push(row);
                        //break;
                    }

                    //columns -> studentName contactlesson1...contactLessonN
                    columns.push('student');
                    var contactLessons = rawDataSubjectRound[0].contactLesson;
                    for (var x in contactLessons) {
                        //console.log(contactLessons[x]);
                        var cl = contactLessons[x];
                        columns.push({
                            id: cl.id,
                            name: contactLessons[x].name
                        });
                        for (var i = 0; i < rows.length; i++) {

                                var studentGrade,
                                    gradeChoiceId,
                                    gradeChoiceName;

                            if(cl.studentGrade.length === 0) {
                                gradeChoiceId = null;
                                studentGrade = null;
                                gradeChoiceName = null;
                            } else {
                                console.log('found grades');
                            }
                            rows[i].push({
                                id: gradeChoiceId,
                                name: gradeChoiceName,
                                studentGrade: studentGrade,
                                contactLessonId: cl.id,
                                studentId: rows[i][0].id,
                                teacherId: teacherId
                            });
                        }
                    }


                    console.log(columns);
                    console.log(rows);
                };

            }

            return diaryController;
        });

}(define, document));

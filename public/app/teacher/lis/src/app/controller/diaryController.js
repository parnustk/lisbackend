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
                            ////console.log('RAW rawDataSubjectRound', rawDataSubjectRound);

                            studentGroupModel.GetList(urlParamsSubjectRound).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {
                                    rawDataStudentGroup = result.data;
                                    ////console.log('rawDataSubjectRound', rawDataSubjectRound);
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

                var searchStudentGrade = function (studentId, studentGrades) {
                    for (var x in studentGrades) {
                        if (studentGrades[x].student.id === studentId) {
                            return {
                                gradeChoiceId: studentGrades[x].gradeChoice.id,
                                gradeChoiceName: studentGrades[x].gradeChoice.name,
                                teacherId: studentGrades[x].teacher.id,
                                studentGradeId: studentGrades[x].id
                            };
                        }
                    }
                    return -1;
                };

                var createColumnName = function (cl) {
                    var dt = new Date(cl.lessonDate.date);
                    return 'cl' + String(dt.getTime()) + String(cl.sequenceNr);
                };

                var sortDataForDiary = function () {
                    columns = [];//tmp
                    rows = [];//tmp

                    var students = rawDataStudentGroup[0].studentInGroups;

                    var u = 0;
                    for (var y in students) {
                        var row = {};
                        row.nr = u;
                        row.student = {
                            id: students[y].student.id,
                            name: students[y].student.name
                        };
                        rows.push(row);
                        u++;
                    }

                    columns.push({
                        field: 'nr',
                        name: 'nr'
                    });

                    columns.push({
                        field: "student['name']",
                        name: "student['name']"
                    });

                    var contactLessons = rawDataSubjectRound[0].contactLesson;

                    for (var x in contactLessons) {

                        var cl = contactLessons[x];
                        console.log(cl);
                        var columnName = createColumnName(cl);
                        var columnDisplayName = contactLessons[x].name;//make it normal

                        columns.push({
                            field: columnName['name'],
                            name: columnName['name'],
                            displayName: columnDisplayName
                            /*,
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            cellFilter: 'griddropdown:this'*/
                        });

                        for (var i = 0; i < rows.length; i++) {
                            var studentGradeId,
                                gradeChoiceId,
                                gradeChoiceName,
                                teacherId,
                                studentId = rows[i].student.id;
                            if (cl.studentGrade.length === 0) {
                                gradeChoiceId = null;
                                studentGradeId = null;
                                gradeChoiceName = null;
                            } else {
                                var r = searchStudentGrade(studentId, cl.studentGrade);
                                if (r !== -1) {
                                    studentGradeId = r.studentGradeId;
                                    gradeChoiceId = r.gradeChoiceId;
                                    gradeChoiceName = r.gradeChoiceName;
                                    teacherId = r.teacherId;
                                }
                            }
                            rows[i][columnName] = {
                                id: gradeChoiceId,
                                name: gradeChoiceName,
                                studentGradeId: studentGradeId,
                                contactLessonId: cl.id,
                                studentId: studentId,
                                teacherId: teacherId
                            };
                        }
                    }

                    console.log(columns);
                    console.log(rows);
                    $scope.clearGridData();
                    
                    $scope.addRows();
                    $scope.addColumns();
                    
                    //http://stackoverflow.com/questions/26925131/how-to-add-a-column-at-runtime-in-a-grid-using-ui-grid
                    //https://www.google.ee/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=angular+ui+grid+add+columns+dynamically
//$scope.gridApi.core.notifyDataChange( uiGridConstants.dataChange.COLUMN );
                    
                };

                $scope.columns = [];

                $scope.gridOptions = {
                    enableSorting: true,
                    columnDefs: $scope.columns,
                    onRegisterApi: function (gridApi) {
                        $scope.gridApi = gridApi;
                    }
                };

                $scope.addColumns = function () {
                    $scope.columns = columns;
                };

                $scope.addRows = function () {
                    $scope.gridOptions.data = rows;
                };

                $scope.clearGridData = function () {
                    $scope.columns.splice($scope.columns.length - 1, 1);
                    $scope.gridOptions.data = [];
                };


            }

            return diaryController;
        });

}(define, document));

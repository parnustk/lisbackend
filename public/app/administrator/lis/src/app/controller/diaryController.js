/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

/* global define */

/**
 * helpers:
 * http://stackoverflow.com/questions/26925131/how-to-add-a-column-at-runtime-in-a-grid-using-ui-grid
 * https://www.google.ee/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=angular+ui+grid+add+columns+dynamically
 * $scope.gridApi.core.notifyDataChange( uiGridConstants.dataChange.COLUMN );
 * http://stackoverflow.com/questions/29219380/ui-grid-dropdown-editor-with-complex-json-object
 * 
 * @param {type} define
 * @returns {undefined}
 * @author Sander Mets <sandermets0@gmail.com>, Juhan Kõks <juhankoks@gmail.com>
 */
(function (define) {
    'use strict';

    define(['angular', 'app/util/globalFunctions', 'moment', 'bootbox'],
            function (angular, globalFunctions, moment, bootbox) {

                diaryController.$inject = [
                    '$scope',
                    'uiGridConstants',
                    'contactLessonModel',
                    'subjectRoundModel',
                    'studentGroupModel',
                    'gradeChoiceModel',
                    'studentGradeModel'
                ];

                function diaryController(
                        $scope,
                        uiGridConstants,
                        contactLessonModel,
                        subjectRoundModel,
                        studentGroupModel,
                        gradeChoiceModel,
                        studentGradeModel) {

                    /* jshint ignore:start */

                    $scope.T = globalFunctions.T;

                    var teacherId = null,
                            rawDataStudentGroup = null,
                            rawDataGradeSR = null,
                            rawDataSubjectRound = null,
                            rawDataGradeIW = null,
                            rawDataGradeMOD = null,
                            clColumns = [],
                            rows = [],
                            originalRows = [],
                            urlParamsSubjectRound = {
                                page: 1,
                                limit: 1000,
                                diaryview: 'diaryview'
                            };

                    $scope.diaryFilter = {};

                    $scope.subjectRounds = [];
                    $scope.studentGroups = [];
                    $scope.gradeChoices = [];
                    $scope.gradeChoiceGradesOnly = [];
                    $scope.absenceReasonsOnly = [];

                    gradeChoiceModel.GetList({}).then(function (result) {//get'em all no params for filter

                        if (globalFunctions.resultHandler(result)) {
                            $scope.gradeChoices = result.data;
                            for (var a in result.data) {
                                if (result.data[a].lisType !== "absencereason") {
                                    $scope.gradeChoiceGradesOnly.push(result.data[a]);
                                } else if (result.data[a].lisType !== "gradechoice") {
                                    $scope.absenceReasonsOnly.push(result.data[a]);
                                }
                            }

                            urlParamsSubjectRound.diaryview = 'diaryInitAdmin';
                            subjectRoundModel.GetList(urlParamsSubjectRound).then(function (result) {//get'em all no params for filter
                                if (globalFunctions.resultHandler(result)) {
                                    $scope.subjectRounds = result.data;

                                    studentGroupModel.GetList(urlParamsSubjectRound).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {
                                            $scope.studentGroups = result.data;

                                        }
                                    });
                                }
                            });
                        }
                    });

                    var isAbsenceReason = function (idAR) {
                        for (var q in $scope.absenceReasonsOnly) {
                            if ($scope.absenceReasonsOnly[q].id === idAR) {
                                return true;
                            }
                        }
                        return false;
                    };

                    $scope.columns = [
                        {
                            name: 'nr',
                            displayName: 'Jrk',
                            visible: false,
                            type: 'number',
                            width: 10,
                            enableCellEdit: false
                        }, {
                            name: "student['name']",
                            displayName: $scope.T('LIS_STUDENT'),
                            enableCellEdit: false,
                            pinnedLeft: true,
                            width: 150
                        }
                    ];

                    $scope.gridOptions = {
                        enableSorting: true,
                        columnDefs: $scope.columns,
                        enableCellEditOnFocus: true,
                        onRegisterApi: function (gridApi) {
                            $scope.gridApi = gridApi;
                            gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
                                //mod

                                if (/^cl/i.test(colDef.name)) {//START CONTACTLESSON Grades CRUD

                                    var x,
                                            buf = {},
                                            newGrade = {},
                                            originalEntity = originalRows[rowEntity.nr][colDef.name];
                                    angular.copy(originalEntity, buf);
                                    for (x in $scope.gradeChoices) {
                                        if ($scope.gradeChoices[x].id === newValue) {
                                            newGrade.id = newValue;
                                            newGrade.name = $scope.gradeChoices[x].name;
                                            break;
                                        }
                                    }
                                    buf.id = newGrade.id;
                                    buf.name = newGrade.name;
                                    var data = {
                                        student: buf.studentId,
                                        gradeChoice: buf.id,
                                        teacher: teacherId,
                                        contactLesson: buf.contactLessonId
                                    };
                                    if (typeof buf.name !== "undefined" && originalEntity.studentGradeId === null && buf.name && buf.name.trim() !== '' && isAbsenceReason(newValue)) {//CREATE
                                        studentGradeModel.Create(data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {//alert('GOOD CREATE');
                                                        buf.studentGradeId = result.data.id;
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        //alert('BAD CREATE');
                                                        buf = originalEntity;//reverse changes if unsuccessful
                                                    }
                                                }
                                        );
                                    } else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId !== null && buf.name && buf.name.trim() !== '' && buf.id !== originalEntity.id && isAbsenceReason(newValue) && isAbsenceReason(oldValue.id)) {//UPDATE
                                        studentGradeModel.Update(originalEntity.studentGradeId, data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
                                                        //alert('GOOD UPDATE');
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        //alert('BAD UPDATE');
                                                        buf = originalEntity;//reverse changes if unsuccessful
                                                    }
                                                }
                                        );
                                    } else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId !== null && buf.name && buf.name.trim() === '' && isAbsenceReason(newValue) && isAbsenceReason(oldValue.id)) {//DELETE
                                        studentGradeModel.Delete(originalEntity.studentGradeId, data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
                                                        //alert('GOOD DELETE');
                                                        buf = {
                                                            id: null,
                                                            name: null,
                                                            studentGradeId: null,
                                                            teacherId: null
                                                        };
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        buf = originalEntity;//reverse changes if unsuccessful//alert('BAD DELETE');
                                                    }
                                                }
                                        );
                                    }
                                   else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId === null && buf.name && buf.name.trim() !== '') {//CREATE
                                        studentGradeModel.Create(data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {//alert('GOOD CREATE');
                                                        buf.studentGradeId = result.data.id;
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        //alert('BAD CREATE');
                                                        buf = originalEntity;//reverse changes if unsuccessful
                                                    }
                                                }
                                        );
                                    } else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId !== null && buf.name && buf.name.trim() !== '' && buf.id !== originalEntity.id) {//UPDATE
                                        studentGradeModel.Update(originalEntity.studentGradeId, data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
                                                        //alert('GOOD UPDATE');
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        //alert('BAD UPDATE');
                                                        buf = originalEntity;//reverse changes if unsuccessful
                                                    }
                                                }
                                        );
                                    } else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId !== null && buf.name.trim() === '') {//DELETE
                                        studentGradeModel.Delete(originalEntity.studentGradeId, data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
                                                        //alert('GOOD DELETE');
                                                        buf = {
                                                            id: null,
                                                            name: null,
                                                            studentGradeId: null,
                                                            teacherId: null
                                                        };
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        buf = originalEntity;//reverse changes if unsuccessful//alert('BAD DELETE');
                                                    }
                                                }
                                        );
                                    }else { //reverse original
                                        buf = originalEntity;
                                        console.log("TESTTTT");
                                    }

                                    rowEntity[colDef.name] = buf;

                                } else if (colDef.name === 'mod') {//START SUBJECTROUND Grades CRUD
                                    console.log("DEBUG2");
                                    var x,
                                            buf = {},
                                            newGrade = {},
                                            originalEntity = originalRows[rowEntity.nr][colDef.name];

                                    angular.copy(originalEntity, buf);
                                    for (x in $scope.gradeChoiceGradesOnly) {
                                        if ($scope.gradeChoiceGradesOnly[x].id === newValue) {
                                            newGrade.id = newValue;
                                            newGrade.name = $scope.gradeChoiceGradesOnly[x].name;
                                            break;
                                        }
                                    }
                                    buf.id = newGrade.id;
                                    buf.name = newGrade.name;
                                    var data = {
                                        student: buf.studentId,
                                        gradeChoice: buf.id,
                                        teacher: teacherId,
                                        module: buf.moduleId
                                    };
                                    console.log(data);
                                    console.log(originalEntity);

                                    if (typeof buf.name !== "undefined" && originalEntity.studentGradeId === null && buf.name && buf.name.trim() !== '') {//CREATE
                                        studentGradeModel.Create(data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {//alert('GOOD CREATE');
                                                        buf.studentGradeId = result.data.id;
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        //alert('BAD CREATE');
                                                        buf = originalEntity;//reverse changes if unsuccessful
                                                    }
                                                }
                                        );
                                    } else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId !== null && buf.name && buf.name.trim() !== '' && buf.id !== originalEntity.id) {//UPDATE

                                        studentGradeModel.Update(originalEntity.studentGradeId, data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {
                                                        //alert('GOOD UPDATE');
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        //alert('BAD UPDATE');
                                                        buf = originalEntity;//reverse changes if unsuccessful
                                                    }
                                                }
                                        );
                                    } else if (typeof buf.name !== "undefined" && originalEntity.studentGradeId !== null && buf.name.trim() === '') {//DELETE
                                        studentGradeModel.Delete(originalEntity.studentGradeId, data).then(
                                                function (result) {
                                                    if (globalFunctions.resultHandler(result)) {//alert('GOOD DELETE');
                                                        buf = {
                                                            id: null,
                                                            name: null,
                                                            studentGradeId: null,
                                                            teacherId: null
                                                        };
                                                        originalEntity = originalRows[rowEntity.nr][colDef.name] = buf;
                                                    } else {
                                                        buf = originalEntity;//reverse changes if unsuccessful//alert('BAD DELETE');
                                                    }
                                                }
                                        );
                                    } else { //reverse original
                                        buf = originalEntity;
                                        console.log("DEBUG3");
                                    }

                                    rowEntity[colDef.name] = buf;

                                } else {//Anomaly
                                    throw 'Whaaaaat column is this?';
                                }
                                $scope.$apply();

                            });

                        }
                    };

                    /**
                     * 
                     * @param {Boolean} valid
                     * @returns {undefined}
                     */
                    $scope.Filter = function (valid) {
                        if (valid) {
                            resetUrlParams();
                            var data = globalFunctions.cleanData($scope.diaryFilter);
                            urlParamsSubjectRound.where = angular.toJson(data);
                            getData();
                        } else {
                            bootbox.alert($scope.T('LIS_CHECK_FORM_FIELDS'));
                        }
                    };

                    $scope.Sort = function () {
                        sortDataForDiary();
                    };

                    $scope.addRows = function () {
                        angular.copy(rows, originalRows);
                        $scope.gridOptions.data = rows;
                        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
                    };

                    /**
                     * See http://stackoverflow.com/questions/1232040/how-do-i-empty-an-array-in-javascript
                     * 
                     * @returns {undefined}
                     */
                    $scope.clearGridData = function () {
                        $scope.columns.splice(2, $scope.columns.length - 2);
                        $scope.gridOptions.data.splice(0, $scope.gridOptions.data.length);
                    };

                    $scope.clDescription = function (c) {
                        var keys = c.colDef.name.split("_"),
                                key = parseInt(keys[1]),
                                cl = clColumns[key],
                                description = cl.description;

                        bootbox.prompt({
                            title: $scope.T('LIS_UPDATE_DESCRIPTION'),
                            value: description,
                            callback: function (d) {

                                if (typeof d === "undefined" || d === null) {
                                    return;
                                }
                                var desc = d.trim();
                                if (desc.length > 0) {
                                    contactLessonModel
                                            .UpdateRegular(cl.id, {
                                                subjectRound: $scope.diaryFilter.subjectRound.id,
                                                description: desc
                                            })
                                            .then(
                                                    function (result) {
                                                        if (globalFunctions.resultHandler(result)) {//alert('GOOD CREATE');
                                                            clColumns[key].description = d;
                                                            getData();
                                                        }
                                                    }
                                            );
                                }
                            }
                        });
                    };

                    var resetUrlParams = function () {
                        urlParamsSubjectRound = {
                            page: 1,
                            limit: 1000,
                            diaryview: 'diaryview'
                        };
                    };

                    /**
                     * We get student related data from by StudentGroup related req, has default params
                     * Grade related data we get by SubjectRound req has params by StudentGroup.
                     * 
                     * @returns {undefined}
                     */
                    var getData = function () {

                        urlParamsSubjectRound.diaryview = 'diaryviewmod';
                        subjectRoundModel.GetList(urlParamsSubjectRound).then(function (result) {//Module grades
                            if (globalFunctions.resultHandler(result)) {
                                rawDataGradeMOD = result.data;

                                urlParamsSubjectRound.diaryview = 'diaryview';
                                subjectRoundModel.GetList(urlParamsSubjectRound).then(function (result) {//CL grades
                                    if (globalFunctions.resultHandler(result)) {
                                        rawDataSubjectRound = result.data;

                                        urlParamsSubjectRound.diaryview = 'diaryviewsr';
                                        subjectRoundModel.GetList(urlParamsSubjectRound).then(function (result) {//SR grades
                                            if (globalFunctions.resultHandler(result)) {
                                                rawDataGradeSR = result.data;

                                                urlParamsSubjectRound.diaryview = 'diaryviewiw';
                                                subjectRoundModel.GetList(urlParamsSubjectRound).then(function (result) {//IW grades
                                                    if (globalFunctions.resultHandler(result)) {
                                                        rawDataGradeIW = result.data;

                                                        urlParamsSubjectRound.diaryview = 'diaryview';
                                                        studentGroupModel.GetList(urlParamsSubjectRound).then(function (result) {
                                                            if (globalFunctions.resultHandler(result)) {
                                                                rawDataStudentGroup = result.data;

                                                                sortDataForDiary();
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });

                            }
                        });
                    };

                    /**
                     * 
                     * @param {type} studentId
                     * @param {type} studentGrades
                     * @returns {diaryController_L15.diaryController_L19.diaryController.searchStudentGrade.diaryControllerAnonym$6|Number}
                     */
                    var searchStudentGrade = function (studentId, studentGrades) {
                        for (var x in studentGrades) {
                            if (studentGrades[x].student.id === studentId) {
                                return {
                                    gradeChoiceId: studentGrades[x].gradeChoice.id,
                                    gradeChoiceName: studentGrades[x].gradeChoice.name,
                                    teacherId: !!studentGrades[x].teacher === true ? studentGrades[x].teacher.id : null,
                                    studentGradeId: studentGrades[x].id
                                };
                            }
                        }
                        return -1;
                    };

                    var createColumnDisplayNameCL = function (cl) {
//                    var dt = new Date(cl.lessonDate.date);
//                    return 'cl' + String(dt.getTime()) + String(cl.sequenceNr);
                        return globalFunctions.formatDate(cl.lessonDate.date) +
                                '-' +
                                String(cl.sequenceNr);
                    };

//                var createColumnDisplayNameIW = function (iw) {
//                    var dt = new Date(iw.duedate.date);
//                    return 'iw' + +String(iw.id) + String(dt.getTime());
//                    //return 'iw' + globalFunctions.formatDate(iw.duedate.date);
//                };

                    var sortDataForDiary = function () {
                        rows = [];
                        if (rawDataStudentGroup.length < 1) {
                            $scope.clearGridData();
                            alert($scope.T('LIS_NO_STUDENTS_IN_GROUP'));
                            return;
                        }
                        if (rawDataSubjectRound.length < 1) {
                            $scope.clearGridData();
                            alert($scope.T('LIS_NO_SUBJECTROUND_OR_CONTACTLESSONS_INSERTED'));
                            return;
                        }

                        var students = rawDataStudentGroup[0].studentInGroups,
                                u = 0,
                                contactLessons = rawDataSubjectRound[0].contactLesson,
                                independentWorks = rawDataGradeIW.length > 0 ? rawDataGradeIW[0].independentWork : [],
                                moduleStudentGrades = rawDataGradeMOD.length > 0 ? rawDataGradeMOD[0].module : [],
                                studentGradesSR = rawDataGradeSR.length > 0 ? rawDataGradeSR[0].studentGrade : [],
                                y,
                                x,
                                z;

                        for (y in students) {
                            var row = {};
                            row.nr = u;
                            row.student = {
                                id: students[y].student.id,
                                name: students[y].student.name
                            };
                            rows.push(row);
                            u++;
                        }

                        var columnNameMOD = 'mod', //add subjectround grade. there is only one subjectround grade per subjectround - no loop is needed
                                newColumnMOD = {//start defining column
                                    //field: columnNameId,
                                    name: columnNameMOD,
                                    displayName: moduleStudentGrades.name,
                                    enableCellEdit: true,
                                    editDropdownOptionsArray: $scope.gradeChoiceGradesOnly,
                                    type: 'object',
                                    editableCellTemplate: 'ui-grid/dropdownEditor',
                                    editDropdownIdLabel: "id",
                                    editDropdownValueLabel: "name",
                                    cellFilter: 'griddropdown:this',
                                    width: 150
                                };

                        $scope.columns.push(newColumnMOD);

                        for (var i = 0; i < rows.length; i++) {
                            var studentGradeId = null,
                                    gradeChoiceId = null,
                                    gradeChoiceName = null,
                                    teacherId = null,
                                    studentId = rows[i].student.id;

                            if (rawDataGradeMOD.length > 0) {

                                if (rawDataGradeMOD[0].module.studentGrade.length !== 0) {
                                    var r = searchStudentGrade(studentId, rawDataGradeMOD[0].module.studentGrade);
                                    if (r !== -1) {
                                        studentGradeId = r.studentGradeId;
                                        gradeChoiceId = r.gradeChoiceId;
                                        gradeChoiceName = r.gradeChoiceName;
                                        teacherId = r.teacherId;
                                    }
                                }
                            }

                            rows[i][columnNameMOD] = {
                                id: gradeChoiceId,
                                name: gradeChoiceName,
                                studentGradeId: studentGradeId,
                                moduleId: rawDataGradeMOD[0].id,
                                studentId: studentId,
                                teacherId: teacherId
                            };
                        }

                        for (x in contactLessons) {//add contact lesson stuff. number of contactlesson is dynamic

                            var cl = contactLessons[x],
                                    toolTip = cl.description ? cl.description : '...',
                                    columnName = 'cl_' + cl.id,
                                    newColumnCL = {
                                        //field: columnNameId,
                                        name: columnName,
                                        displayName: createColumnDisplayNameCL(cl),
                                        enableCellEdit: true,
                                        editDropdownOptionsArray: $scope.gradeChoices,
                                        type: 'object',
                                        editableCellTemplate: 'ui-grid/dropdownEditor',
                                        editDropdownIdLabel: "id",
                                        editDropdownValueLabel: "name",
                                        cellFilter: 'griddropdown:this',
                                        width: 150,
                                        headerTooltip: toolTip,
                                        menuItems: [{
                                                title: $scope.T('LIS_LESSON_DESCRIPTION'),
                                                icon: 'ui-grid-icon-info-circled',
                                                action: function () {
                                                    $scope.clDescription(this.context.col); // $scope.clDescription() would work too, this is just an example
                                                }
                                            }]
                                    };

                            clColumns[parseInt(cl.id)] = cl;

                            $scope.columns.push(newColumnCL);

                            for (var i = 0; i < rows.length; i++) {
                                var studentGradeId = null,
                                        gradeChoiceId = null,
                                        gradeChoiceName = null,
                                        teacherId = null,
                                        studentId = rows[i].student.id;

                                if (cl.studentGrade.length !== 0) {
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

                        for (z in independentWorks) {//add independentwork stuff. number of iw is dynamic

                            var iw = independentWorks[z],
                                    columnName = 'iw_' + iw.id,
                                    toolTip = (
                                            iw.name + "\n" +
                                            iw.description + "\n" +
                                            globalFunctions.formatDate(iw.duedate.date) + "\n" +
                                            iw.durationAK + 'AK'),
                                    newColumnIW = {//think of tooltips
                                        //field: columnNameId,
                                        name: columnName,
                                        displayName: iw.name,
                                        enableCellEdit: false,
                                        editDropdownOptionsArray: $scope.gradeChoiceGradesOnly,
                                        type: 'object',
                                        editableCellTemplate: 'ui-grid/dropdownEditor',
                                        editDropdownIdLabel: "id",
                                        editDropdownValueLabel: "name",
                                        cellFilter: 'griddropdown:this',
                                        headerTooltip: toolTip,
                                        width: 150
                                    };

                            $scope.columns.push(newColumnIW);

                            for (var i = 0; i < rows.length; i++) {
                                var studentGradeId = null,
                                        gradeChoiceId = null,
                                        gradeChoiceName = null,
                                        teacherId = null,
                                        studentId = rows[i].student.id;

                                if (iw.studentGrade.length !== 0) {
                                    var r = searchStudentGrade(studentId, iw.studentGrade);
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
                                    independentWorkId: iw.id,
                                    studentId: studentId,
                                    teacherId: teacherId
                                };
                            }
                        }

                        var columnNameSR = 'sr', //add subjectround grade. there is only one subjectround grade per subjectround - no loop is needed
                                newColumnSR = {//start defining column
                                    //field: columnNameId,
                                    name: columnNameSR,
                                    displayName: $scope.T('LIS_SUBJECTROUND_GRADE'),
                                    enableCellEdit: false,
                                    editDropdownOptionsArray: $scope.gradeChoiceGradesOnly,
                                    type: 'object',
                                    editableCellTemplate: 'ui-grid/dropdownEditor',
                                    editDropdownIdLabel: "id",
                                    editDropdownValueLabel: "name",
                                    cellFilter: 'griddropdown:this',
                                    width: 150
                                };

                        $scope.columns.push(newColumnSR);

                        for (var i = 0; i < rows.length; i++) {
                            var studentGradeId = null,
                                    gradeChoiceId = null,
                                    gradeChoiceName = null,
                                    teacherId = null,
                                    studentId = rows[i].student.id;

                            if (rawDataGradeSR.length > 0) {

                                if (studentGradesSR.length !== 0) {
                                    var r = searchStudentGrade(studentId, studentGradesSR);
                                    if (r !== -1) {
                                        studentGradeId = r.studentGradeId;
                                        gradeChoiceId = r.gradeChoiceId;
                                        gradeChoiceName = r.gradeChoiceName;
                                        teacherId = r.teacherId;
                                    }
                                }
                            }

                            rows[i][columnNameSR] = {
                                id: gradeChoiceId,
                                name: gradeChoiceName,
                                studentGradeId: studentGradeId,
                                subjectRoundId: $scope.diaryFilter.subjectRound.id,
                                studentId: studentId,
                                teacherId: teacherId
                            };
                        }

                        $scope.addRows();
                    };
                    /* jshint ignore:end */
                }

                return diaryController;
            });

}(define));

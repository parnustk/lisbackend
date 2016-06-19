/* global define */

/**
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * @author Alar Aasa <alar@alaraasa.ee>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 * @author Eleri Apsolon <sandermets0@gmail.com>
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {subjectRoundController_L19.subjectRoundController_L26.subjectRoundController}
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            subjectRoundController.$inject = [
                '$scope',
                '$q',
                'uiGridConstants',
                'subjectRoundModel',
                'subjectModel',
                'studentGroupModel',
                'teacherModel',
                'vocationModel',
                'moduleModel'
            ];

            function subjectRoundController(
                $scope,
                $q,
                uiGridConstants,
                subjectRoundModel,
                subjectModel,
                studentGroupModel,
                teacherModel,
                vocationModel,
                moduleModel) {

                $scope.T = globalFunctions.T;

                var urlParams = {
                    page: 1,
                    limit: 1000
                };

                $scope.model = {
                    id: null,
                    name: null,
                    status: null,
                    subject: null,
                    studentGroup: null,
                    teacher: null,
                    vocation: null,
                    module: null,
                    trashed: null
                };

                $scope.vocations = [];
                $scope.modules = [];
                $scope.subjects = [];
                $scope.studentGroups = [];
                $scope.teachers = [];

                $scope.modulesInVocation = [];
                $scope.studentGroupsInVocation = [];
                $scope.subjectsInModule = [];

                $scope.subjectRound = {};
                $scope.filterSubjectRound = {};

                $scope.subjectRound = {};
                $scope.subjectRound.status = 1;

                $scope.gridOptions = {
                    rowHeight: 38,
                    enableCellEditOnFocus: true,
                    columnDefs: [
                        {
                            field: 'id',
                            visible: false,
                            type: 'number',
                            enableCellEdit: false,
                            width: 10,
                            sort: {
                                direction: uiGridConstants.DESC,
                                priority: 1
                            }
                        },
                        {
                            field: 'name',
                            displayName: $scope.T('LIS_NAME'),
                            pinnedLeft: true,
                            width: 200
                        },
                        {
                            field: "vocation",
                            name: "vocation",
                            displayName: $scope.T('LIS_VOCATION'),
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this',
                            width: 200
                        },
                        {
                            field: "module",
                            name: "module",
                            displayName: $scope.T('LIS_MODULE'),
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this',
                            width: 200
                        },
                        {
                            field: "subject",
                            name: "subject",
                            displayName: $scope.T('LIS_SUBJECT'),
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this',
                            width: 200
                        },
                        {
                            field: "studentGroup",
                            name: "studentGroup",
                            displayName: $scope.T('LIS_STUDENTGROUP'),
                            editableCellTemplate: 'lis/dist/templates/partial/uiSingleSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            sortCellFiltered: $scope.sortFiltered,
                            cellFilter: 'griddropdown:this',
                            width: 200
                        },
                        {
                            field: 'teacher',
                            name: 'teacher',
                            displayName: $scope.T('LIS_TEACHER'),
                            cellTemplate: "<div class='ui-grid-cell-contents'><span ng-repeat='field in COL_FIELD'>{{field.name}}</span></div>",
                            editableCellTemplate: 'lis/dist/templates/partial/uiMultiNameSelect.html',
                            editDropdownIdLabel: "id",
                            editDropdownValueLabel: "name",
                            width: 200
                        },
                        {
                            field: 'status',
                            displayName: $scope.T('LIS_STATUS'),
                            width: 50
                        },
                        {
                            field: 'trashed',
                            displayName: $scope.T('LIS_TRASHED'),
                            width: 50
                        }
                    ],
                    enableGridMenu: true,
                    enableSelectAll: true,
                    exporterCsvFilename: 'subjectround.csv',
                    exporterPdfDefaultStyle: {fontSize: 9},
                    exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                    exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
                    exporterPdfHeader: {text: "Subject round Header", style: 'headerStyle'},
                    exporterPdfFooter: function (currentPage, pageCount) {
                        return {text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle'};
                    },
                    exporterPdfCustomFormatter: function (docDefinition) {
                        docDefinition.styles.headerStyle = {fontSize: 22, bold: true};
                        docDefinition.styles.footerStyle = {fontSize: 10, bold: true};
                        return docDefinition;
                    },
                    exporterPdfOrientation: 'portrait',
                    exporterPdfPageSize: 'LETTER',
                    exporterPdfMaxGridWidth: 500,
                    exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location"))

                };

                /**
                 * 
                 * @returns {undefined}
                 */
                var resetUrlParams = function () {
                    if (urlParams.hasOwnProperty('where')) {
                        delete urlParams.where;
                    }
                    urlParams = {
                        page: 1,
                        limit: 1000
                    };
                };

                /**
                 * 
                 * @param {Array} items
                 * @returns {undefined}
                 */
                var resetDependentDropDowns = function (items) {
                    for (var x in items) {
                        var item = items[x];
                        for (var y in item) {
                            $scope.subjectRound[y] = null;
                            $scope[item[y]].splice(0, $scope[item[y]].length);
                        }
                    }
                    $scope.subjectRound.teacher = null;
                    $scope.subjectRound.name = null;
                };

                /**
                 * 
                 * @param {type} vocationId
                 * @returns {undefined}
                 */
                var getModulesInVocation = function (vocationId) {

                    var params = {
                        vocation: parseInt(vocationId, 10)
                    };

                    resetUrlParams();
                    urlParams.where = angular.toJson(params);
                    moduleModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.modulesInVocation = result.data;
                        }
                    });
                };

                /**
                 * 
                 * @param {type} vocationId
                 * @returns {undefined}
                 */
                var getStudentGroupsInVocation = function (vocationId) {
                    var params = {
                        vocation: parseInt(vocationId, 10)
                    };
                    resetUrlParams();
                    urlParams.where = angular.toJson(params);
                    studentGroupModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.studentGroupsInVocation = result.data;
                        }
                    });
                };

                /**
                 * 
                 * @param {type} moduleId
                 * @returns {undefined}
                 */
                var getSubjectsInModule = function (moduleId) {
                    var params = {
                        module: parseInt(moduleId, 10)
                    };
                    resetUrlParams();
                    urlParams.where = angular.toJson(params);
                    subjectModel.GetList(urlParams).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {
                            $scope.subjectsInModule = result.data;
                        }
                    });
                };

                /**
                 * Resets dependent fields
                 * Fields' content by vocation PK
                 * 
                 * @param {type} $item
                 * @returns {undefined}
                 */
                $scope.onSelectVocation = function ($item) {
                    $scope.subjectRound.module = null;
                    resetDependentDropDowns([
                        {
                            module: 'modulesInVocation'
                        }, {
                            studentGroup: 'studentGroupsInVocation'
                        }, {
                            subject: 'subjectsInModule'
                        }
                    ]);
                    getModulesInVocation($item.id);
                    getStudentGroupsInVocation($item.id);
                };

                /**
                 * 
                 * @param {type} $item
                 * @returns {undefined}
                 */
                $scope.onSelectModule = function ($item) {
                    resetDependentDropDowns([{subject: 'subjectsInModule'}]);
                    getSubjectsInModule($item.id);
                };

                /**
                 * 
                 * @param {type} $item
                 * @returns {undefined}
                 */
                $scope.onSelectSubject = function ($item) {
                    $scope.subjectRound.name = $item.name;
                };

                /**
                 *
                 * @param gridApi
                 */
                $scope.gridOptions.onRegisterApi = function (gridApi) {
                    $scope.gridApi = gridApi;
                    gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                };

                /**
                 *
                 * @param rowEntity
                 */
                $scope.saveRow = function (rowEntity) {
                    var deferred = $q.defer();
                    subjectRoundModel.Update(rowEntity.id, rowEntity).then(
                        function (result) {
                            if (result.success) {
                                deferred.resolve();
                            } else {
                                deferred.reject();
                            }
                        }
                    );
                    $scope.gridApi.rowEdit.setSavePromise(rowEntity, deferred.promise);

                };

                /**
                 * 
                 * @param {Boolean} valid
                 * @returns {undefined}
                 */
                $scope.Create = function (valid) {
                    resetUrlParams();
                    if (valid) {
                        subjectRoundModel.Create($scope.subjectRound).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                resetDependentDropDowns([
                                    {
                                        module: 'modulesInVocation'
                                    }, {
                                        studentGroup: 'studentGroupsInVocation'
                                    }, {
                                        subject: 'subjectsInModule'
                                    }
                                ]);
                                LoadGrid();
                            }
                        });
                    } else {
                        globalFunctions.alertMsg(T('LIS_CHECK_FORM_FIELDS'));
                    }
                };

                /**
                 *
                 * @constructor
                 */
                $scope.Filter = function () {
                    resetUrlParams();
                    if (!angular.equals({}, $scope.items)) {
                        urlParams.where = angular.toJson(globalFunctions.cleanData($scope.filterSubjectRound));
                        LoadGrid();
                    }
                };

                /**
                 *
                 * @constructor
                 */
                $scope.ClearFilters = function () {
                    $scope.filterSubjectRound = {};
                    delete urlParams.where;
                    resetUrlParams();
                    LoadGrid();
                };

                /**
                 *
                 * @constructor
                 */
                function LoadGrid() {
                    vocationModel.GetList({}).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {

                            $scope.gridOptions.columnDefs[2].editDropdownOptionsArray = $scope.vocations = result.data;

                            moduleModel.GetList({}).then(function (result) {
                                if (globalFunctions.resultHandler(result)) {

                                    $scope.gridOptions.columnDefs[3].editDropdownOptionsArray = $scope.modules = result.data;

                                    subjectModel.GetList({}).then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {

                                            $scope.subjects = result.data;
                                            $scope.gridOptions.columnDefs[4].editDropdownOptionsArray = $scope.subjects;

                                            studentGroupModel.GetList($scope.params).then(function (result) {
                                                $scope.studentGroups = result.data;
                                                $scope.gridOptions.columnDefs[5].editDropdownOptionsArray = $scope.studentGroups;

                                                teacherModel.GetList($scope.params).then(function (result) {
                                                    $scope.teachers = result.data;
                                                    $scope.gridOptions.columnDefs[6].editDropdownOptionsArray = $scope.teachers;

                                                    subjectRoundModel.GetList(urlParams).then(function (result) {
                                                        if (globalFunctions.resultHandler(result)) {
                                                            $scope.gridOptions.data = result.data;
                                                        }
                                                    });
                                                });

                                            });
                                        }
                                    });
                                }
                            });

                        }
                    });
                }

                LoadGrid();
            }


            return subjectRoundController;
        });

}(define, document));
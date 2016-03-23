/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

/**
 * 
 * @param {type} define
 * @returns {undefined}
 * @author Arnold Tserepov <tserepov@gmail.com>
 */
(function (define, document) {
    'use strict';
    
    define(['angular'], function (angular) {

        /**
         * 
         * @param {Object} result
         * @returns {Boolean}
         */
        var _resultHandler = function (result) {
            var s = true;
            if (!result.success && result.message === "NO_USER") {
                alert('Login!');
                s = false;
            }
            return s;
        };

        function gradeChoiceController($scope, $routeParams, gradeChoiceModel) {

            $scope.model = {
                id: null,
                name: null,
                studentGrade: null,
                trashed: null
            };
            
            $scope.store = [];

            $scope.params = {};

            $scope.gridOptions = {
                enableCellEditOnFocus: true,
                columnDefs: [
                    {field: 'id', visible: false},
                    {field: 'name'},
                    {field: 'studentGrade'},
                    {field: 'trashed'}
                ],
                enableGridMenu: true,
                enableSelectAll: true,
                exporterCsvFilename: 'gradeChoice.csv',
                exporterPdfDefaultStyle: {fontSize: 9},
                exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
                exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
                exporterPdfHeader: {text: "My Header", style: 'headerStyle'},
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
                exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),/*
                onRegisterApi: function (gridApi) {
                    $scope.gridApi = gridApi;
                    gridApi.cellNav.on.navigate($scope, function (newRowCol, oldRowCol) {
                        // var rowCol = {row: newRowCol.row.index, col:newRowCol.col.colDef.name};
                        // var msg = 'New RowCol is ' + angular.toJson(rowCol);
                        // if(oldRowCol){
                        //    rowCol = {row: oldRowCol.row.index, col:oldRowCol.col.colDef.name};
                        //    msg += ' Old RowCol is ' + angular.toJson(rowCol);
                        // }
                        console.log('navigation event', newRowCol, oldRowCol);
                    });
                    gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
                }*/
            };
            
            $scope.gridOptions.onRegisterApi = function (gridApi) {
                //set gridApi on scope
                $scope.gridApi = gridApi;
                gridApi.rowEdit.on.saveRow($scope, $scope.saveRow);
            };

            $scope.init = function () {
                gradeChoiceModel.GetList($scope.params).then(
                    function (result) {
                        if (_resultHandler(result)) {
                            $scope.store = $scope.gridOptions.data = result.data;
                            console.log($scope.gridApi);
                        }
                        console.log($scope.store);
                    }
                );
            };
            
            $scope.saveRow = function (rowEntity) {
 //                console.log(rowEntity);
                 var promise = gradeChoiceModel.Update(rowEntity.id, rowEntity);
 //                // create a fake promise - normally you'd use the promise returned by $http or $resource
 //                var promise = $q.defer();
                 $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);
 //
 //                // fake a delay of 3 seconds whilst the save occurs, return error if gender is "male"
 //                $interval(function () {
 //                    if (rowEntity.gender === 'male') {
 //                        promise.reject();
 //                    } else {
 //                        promise.resolve();
 //                    }
 //                }, 3000, 1);
             };

            $scope.init();

        }

        gradeChoiceController.$inject = ['$scope', '$routeParams', 'gradeChoiceModel'];

        return gradeChoiceController;
    });

}(define, document));



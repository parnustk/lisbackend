/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

(function (define) {
    'use strict';

    define([], function () {

        function gradeChoiceController($scope, $routeParams, gradeChoiceModel) {
            /*
             * 
             code: "56ab3365875dc"
             email: "56ab33658763b@asd.ee"
             firstName: "tFirstName56ab336587531"
             lastName: "tLirstName56ab336587590"
             */
//
//            $scope.gradeChoice = {
//                name: ''
//            };
            $scope.Create = function () {
                gradeChoiceModel
                    .Create($scope.gradeChoice)
                    .then(
                        function (result) {
                            if(result.success) {
                                alert('GOOD');
                            } else {
                                alert('BAAAD');
                            }
                        }
                    );
            };

//            $scope.emptyGradeChoice = {
//                id: -1,
//                name: ''
//            };
//
//            
//            $scope.reset = function () {
//                $scope.user = angular.copy($scope.master);
//            };
//            $scope.reset();
            /*
             var params = {page: 2, limit: 3};
             gradeChoiceModel.GetList(params).then(
             function (result) {
             $scope.gradeChoice = result.data;
             }
             );*/
        }

        gradeChoiceController.$inject = ['$scope', '$routeParams', 'gradeChoiceModel'];

        return gradeChoiceController;
    });

}(define));

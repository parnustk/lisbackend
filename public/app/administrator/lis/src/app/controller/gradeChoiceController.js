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


            $scope.gradeChoice = {
                name: ''
            };
            $scope.Create = function () {
                gradeChoiceModel
                        .Create($scope.gradeChoice)
                        .then(
                                function (result) {
                                    if (result.success) {
                                        alert('GOOD');
                                    } else {
                                        alert('BAD');
                                    }
                                }
                        );
            };
            $scope.Get = function (id) {
                gradeChoiceModel
                        .Get($scope.gradeChoice.id)
                        .then(
                                function (result) {
                                    if (result.success) {
                                        alert('GOOD');
                                    } else {
                                        alert('BAD');
                                    }
                                }
                        );
            };
            console.log('tere');
        }

        gradeChoiceController.$inject = ['$scope', '$routeParams', 'gradeChoiceModel'];

        return gradeChoiceController;
    });

}(define));

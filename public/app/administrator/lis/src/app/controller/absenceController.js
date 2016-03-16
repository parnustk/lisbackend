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
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
(function (define) {
    'use strict';

    define([], function () {

        function absenceController($scope, $routeParams, absenceModel) {

            $scope.absence = {
                description: '',
                student:'',
                contactLesson:'',
                absenceReason:''
            };

            $scope.Create = function () {
                absenceModel
                        .Create($scope.absence)
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

//            $scope.reset = function () {
//                $scope.name
//            }
//            var params = {page:2, limit:5};
//            absenceModel.GetList(params).then(
//                    function (result) {
//                        $scope.absence =result.data;
//                        console.log($scope.absence);
//                    }
//            );

            console.log('tere');
        }

        absenceController.$inject = ['$scope', '$routeParams', 'absenceModel'];

        return absenceController;
    });

}(define));



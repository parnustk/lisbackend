/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

(function (define) {
    'use strict';

    define([], function () {

        function teacherController($scope, $routeParams, teacherModel) {
            /*
             * 
             code: "56ab3365875dc"
             email: "56ab33658763b@asd.ee"
             firstName: "tFirstName56ab336587531"
             lastName: "tLirstName56ab336587590"
             */
//
//            $scope.teacher = {
//                firstName: '',
//                lastName: '',
//                code: '',
//                email: ''
//            };
            $scope.Create = function () {
                teacherModel
                    .Create($scope.teacher)
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

//            $scope.emptyTeacher = {
//                id: -1,
//                firstName: '',
//                lastName: '',
//                code: '',
//                email: ''
//            };
//
//            
//            $scope.reset = function () {
//                $scope.user = angular.copy($scope.master);
//            };
//            $scope.reset();
            /*
             var params = {page: 2, limit: 3};
             teacherModel.GetList(params).then(
             function (result) {
             $scope.teachers = result.data;
             }
             );*/
        }

        teacherController.$inject = ['$scope', '$routeParams', 'teacherModel'];

        return teacherController;
    });

}(define));



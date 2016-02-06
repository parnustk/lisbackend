/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * @param {type} define
 * @returns {undefined}
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
(function (define) {
    'use strict';

    define([], function () {

        function absencereasonController($scope, $routeParams, absencereasonModel) {

            $scope.absencereason = {
                name: ''
            };

            $scope.Create = function () {
                absencereasonModel
                        .Create($scope.absencereason)
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
                absencereasonModel
                        .Get($scope.absencereason.id)
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
//            absencereasonModel.GetList(params).then(
//                    function (result) {
//                        $scope.absencereason =result.data;
//                        console.log($scope.absencereason);
//                    }
//            );

            console.log('tere');
        }

        absencereasonController.$inject = ['$scope', '$routeParams', 'absencereasonModel'];

        return absencereasonController;
    });

}(define));



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
(function (define) {
    'use strict';

    define([], function () {

        function roomController($scope, $routeParams, roomModel) {

            $scope.room = {
                name: ''
            };

            $scope.Create = function () {
                roomModel
                        .Create($scope.room)
                        .then(
                                function (result) {
                                    if (result.success) {
                                        alert('Works');
                                    } else {
                                        alert('Broken');
                                    }
                                }
                        );
            };
   
        }

        roomController.$inject = ['$scope', '$routeParams', 'roomModel'];

        return roomController;
    });

}(define));



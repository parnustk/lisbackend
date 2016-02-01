/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

(function (define) {
    'use strict';

    define([], function () {

        function moduleTypeController($scope, $routeParams, moduleTypeModel) {

            moduleTypeModel.GetList().then(
                    function (result) {
                        $scope.moduletypes = result.data;
                    }
            );
        }

        moduleTypeController.$inject = ['$scope', '$routeParams', 'moduleTypeModel'];

        return moduleTypeController;
    });

}(define));



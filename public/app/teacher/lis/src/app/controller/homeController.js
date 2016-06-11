/* global define */

/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */

/**
 * 
 * @param {type} define
 * @returns {undefined}
 */
(function (define) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {homeController_L11.homeController_L23.homeController}
     */
    define(['angular', 'app/util/globalFunctions'],
        function (angular, globalFunctions) {

            homeController.$inject = ['$scope'];
            
            /**
             * 
             * @param {type} $scope
             * @returns {undefined}
             */
            function homeController($scope) {
                $scope.T = globalFunctions.T;
            }

            return homeController;
        });

}(define));



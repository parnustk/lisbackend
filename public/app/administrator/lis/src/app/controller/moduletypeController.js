/** 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* global define */

(function (define) {
    'use strict';

    define([], function () {

        function moduletypeController($scope, $routeParams, moduletypeModel) {
            $scope.Create = function () {

                moduletypeModel.Create($scope.moduletype).then(
                        function (result) {
                            if (result.success) {
                                alert('GOOD');
                            } else {
                                alert('BAAAD');
                            }
                        }
                );
            };
        }

        moduletypeController.$inject = ['$scope', '$routeParams', 'moduletypeModel'];

        return moduletypeController;
    });

}(define));



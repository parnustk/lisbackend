/* 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* global define */

/**
 * 
 * @param {type} define
 * @returns {undefined}
 * @author Sander Mets <sandermets0@gmail.com>
 */
(function (define) {
    'use strict';

    define([], function () {

        function loginController($scope, loginModel) {

            $scope.credentials = {
                email: 'admin@test.ee',
                password: 'Tere1234'
            };

            $scope.Login = function () {

                console.log($scope.credentials);

                loginModel
                        .Create($scope.credentials)
                        .then(function (result) {
                            if (result.success) {
                                alert('GOOD');
                            } else {
                                alert('BAD');
                            }
                        });
            };
            $scope.Logout = function () {
                loginModel.Delete();
            };
        }

        loginController.$inject = ['$scope', 'loginModel'];

        return loginController;
    });

}(define));
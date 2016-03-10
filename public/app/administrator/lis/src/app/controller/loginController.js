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
        }

        loginController.$inject = ['$scope', 'loginModel'];

        return loginController;
    });

}(define));



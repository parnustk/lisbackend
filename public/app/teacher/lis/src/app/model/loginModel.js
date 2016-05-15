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
 * @param {type} window
 * @returns {undefined}
 */
(function (define, window) {
    'use strict';
    define([], function () {

        /**
         * 
         * @param {type} $http
         * @param {type} $resource
         * @return {absenceModel_L6.absenceModel.absenceModelAnonym$3}
         */
        function loginModel($http, $resource) {

            var _login;
            _login = $resource(
                window.LisGlobals.RegisterUrl + 'loginteacher/:id',
                {id: '@id'},
                {
                    save: {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    },
                    update: {method: "PUT"},
                    query: {method: 'GET', isArray: false},
                    remove: {method: "DELETE", isArray:true}
                }
            );
            return {
                /**
                 * 
                 * @param {type} data
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Create: function (data) {
                    return _login.save(data).$promise;
                },
                 Delete: function (id) {
                    return _login.remove({id: id}).$promise;
                }
               
            };
        }
        loginModel.$inject = ['$http', '$resource'];
        return loginModel;
    });
}(define, window));
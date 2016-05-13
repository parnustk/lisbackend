/*
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* global define */


(function (define, window) {
   'use strict';
    define([], function() {

        /**
         *
         * @param $http
         * @param $resource
         * @returns {{Create: Create}}
         */
        function registerModel($http, $resource) {
            var _login;
            _login = $resource(
                window.LisGlobals.RegisterUrl + 'registeradministrator/:id',
                {id: '@id'},
                {
                    save: {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                }
            );
            return {
                /**
                 *
                 * @param data
                 * @returns {angular.IPromise<Array<T>>|angular.IPromise<T>|angular.IPromise<IResourceArray<T>>|*|Function}
                 * @constructor
                 */
                Create: function (data) {
                    return _login.save(data).$promise;
                }
            };
        }
        registerModel.$inject = ['$http', '$resource'];
        return registerModel;
    });
}(define, window));

/* 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* global define */

/**
 * 
 * @param {Function} define
 * @param {Object} window
 * @returns {undefined}
 */
(function (define, window) {
    'use strict';

    define([], function () {

        loginModel.$inject = ['$resource'];

        /**
         * 
         * @param {type} $resource
         * @returns {loginModel_L16.loginModel_L19.loginModel.loginModelAnonym$3}
         */
        function loginModel($resource) {

            var _model;

            _model = $resource(
                window.LisGlobals.RegisterUrl + 'loginadministrator/:id',
                {
                    id: '@id'
                },
                {
                    query: {
                        method: 'GET',
                        isArray: false,
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    },
                    save: {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    },
                    remove: {
                        method: "DELETE",
                        isArray: true,
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                }
            );

            return {
                /**
                 * Check user session
                 * 
                 * @param {type} params
                 * @return {unresolved}
                 */
                GetList: function (params) {
                    return _model.query(params).$promise;
                },
                /**
                 * Create user session
                 * 
                 * @param {type} data
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Create: function (data) {
                    return _model.save(data).$promise;
                },
                /**
                 * Delte user session
                 * 
                 * @param {type} id
                 * @returns {unresolved}
                 */
                Delete: function (id) {
                    return _model.remove({id: id}).$promise;
                }
            };
        }
        return loginModel;
    });
}(define, window));
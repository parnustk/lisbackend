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
         * @return {vocationModel_L6.vocationModel.vocationModelAnonym$3}
         */
        function moduleModel($http, $resource) {

            var _model;

            var cleanedData = {};

            
            /**
             * 
             * @param {type} o
             * @returns {unresolved}
             */
            function _removePropertyExceptId(data) {
                cleanedData = {};
                function innerLogic(o) {
                    for (var p in o) {

                        if (Array.isArray(o.p)) {
                            for (var i = 0; i < o.p.length; i++) {
                                innerLogic(o.p[i]);
                            }
                        }

                        if (o.p === Object(o.p)) {
                            innerLogic(o.p);
                        }

                        if (p === 'id') {
                            continue;
                        }

                        console.log('delete', o.p);
                        delete o.p;
                    }
                }
                innerLogic(data);
                console.log(data);
                cleanedData = data;
                debugger;
            }

            _model = $resource(
                window.LisGlobals.RestUrl + 'module/:id',
                {id: '@id'},
                {
                    update: {method: "PUT"},
                    query: {method: 'GET', isArray: false}
                }
            );

            return {
                /**
                 * 
                 * @param {type} params
                 * @return {unresolved}
                 */
                GetList: function (params) {
                    return _model.query(params).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @return {unresolved}
                 */
                Get: function (id) {
                    return _model.get({id: id}).$promise;
                },
                /**
                 * 
                 * @param {type} data
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Create: function (data) {
                    return _model.save(data).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @return {undefined}
                 */
                Update: function (id, data) {
                    _removePropertyExceptId(data);
                    return _model.update({id: id}, cleanedData).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Delete: function (id) {
                    //TODO
                }
            };
        }

        moduleModel.$inject = ['$http', '$resource'];

        return moduleModel;
    });

}(define, window));


/* 
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
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

    define([
        'app/util/globalFunctions'
    ], function (globalFunctions) {

        /**
         * 
         * @param {type} $http
         * @param {type} $resource
         * @return {roomModel_L6.roomModel.roomModelAnonym$3}
         */
        function roomModel($http, $resource) {

            var _model;

            _model = $resource(
                window.LisGlobals.RestUrl + 'room/:id',
                {id: '@id'},
                {
                    update: {method: "PUT"},
                    query: {method: 'GET', isArray: false}
                }
            );

            return {
                /**
                 *
                 * @param params
                 * @returns {*|Function}
                 * @constructor
                 */
                GetList: function (params) {
                    return _model.query(params).$promise;
                },
                /**
                 *
                 * @param id
                 * @returns {*|Function}
                 * @constructor
                 */
                Get: function (id) {
                    return _model.get({id: id}).$promise;
                },
                /**
                 *
                 * @param data
                 * @returns {*|Function}
                 * @constructor
                 */
                Create: function (data) {
                    return _model.save(globalFunctions.cleanData(data)).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @return {undefined}
                 */
                Update: function (id, data) {
                    return _model.update({id: id}, globalFunctions.cleanData(data)).$promise;

                },
                /**
                 * 
                 * @param {type} id
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Delete: function (id) {
                    return _model.remove({id: id}).$promise;
                }
            };
        }
        roomModel.$inject = ['$http', '$resource'];
        return roomModel;
    });

}(define, window));


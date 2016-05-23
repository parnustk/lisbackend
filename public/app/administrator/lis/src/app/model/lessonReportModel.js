/*
 * Licence of Learning Info System (LIS)
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/* global define */


(function (define, window) {
    'use strict';
    define([
        'app/util/globalFunctions'
    ], function (globalFunctions) {
        /**
         *
         * @param $http
         * @param $resource
         */
       function lessonReportModel ($http, $resource) {
            var _model;
            _model = $resource(
                window.LisGlobals.RestUrl + 'lessonReport/:id',
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
                 * @returns {angular.IPromise<Array<T>>|angular.IPromise<IResourceArray<T>>|angular.IPromise<T>|*|Function}
                 * @constructor
                 */
                GetList: function (params) {
                    return _model.query(params).$promise;
                },

                /**
                 *
                 * @param id
                 * @returns {angular.IPromise<Array<T>>|angular.IPromise<IResourceArray<T>>|angular.IPromise<T>|*|Function}
                 * @constructor
                 */
                Get: function(id) {
                    return _model.get({id: id}).$promise;
                },

                /**
                 *
                 * @param data
                 * @returns {angular.IPromise<Array<T>>|angular.IPromise<IResourceArray<T>>|angular.IPromise<T>|*|Function}
                 * @constructor
                 */
                Create: function(data) {
                    return _model.save(globalFunctions.cleanData(data)).$promise;
                },

                /**
                 *
                 * @param id
                 * @param data
                 * @returns {angular.IPromise<Array<T>>|angular.IPromise<IResourceArray<T>>|angular.IPromise<T>|*|Function}
                 * @constructor
                 */
                Update: function (id, data) {
                    return _model.update({id: id}, globalFunctions.cleanData(data)).$promise;
                },

                /**
                 *
                 * @param id
                 * @returns {angular.IPromise<Array<T>>|angular.IPromise<IResourceArray<T>>|angular.IPromise<T>|*|Function}
                 * @constructor
                 */
                Delete: function(id) {
                    return _model.remove({id: id}).$promise;
                }
            };
       }
        lessonReportModel.$inject = ['$http', '$resource'];
        return lessonReportModel;
    });
}(define, window));
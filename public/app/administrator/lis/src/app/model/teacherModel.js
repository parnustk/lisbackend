/** 
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
 * @author Sander Mets
 */
(function (define, window) {
    'use strict';

    define([], function () {

        /**
         * 
         * @param {type} $http
         * @param {type} $resource
         * @returns {teacherModel_L16.teacherModel_L19.teacherModel.teacherModelAnonym$3}
         */
        function teacherModel($http, $resource) {

            var _teacher;

            _teacher = $resource(
                window.LisGlobals.RestUrl + 'teacher/:id',
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
                 * @returns {unresolved}
                 */
                GetList: function (params) {
                    return _teacher.query(params).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @returns {unresolved}
                 */
                Get: function (id) {
                    return _teacher.get({id: id}).$promise;
                },
                /**
                 * 
                 * @param {type} data
                 * @returns {unresolved}
                 */
                Create: function (data) {
                    return _teacher.save(data).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @returns {unresolved}
                 */
                Update: function (id, data) {
                    return _teacher.update({id: id}, data).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @returns {unresolved}
                 */
                Delete: function (id) {
                    return _teacher.delete({id: id}).$promise;
                }
            };
        }
        teacherModel.$inject = ['$http', '$resource'];
        return teacherModel;
    });

}(define, window));


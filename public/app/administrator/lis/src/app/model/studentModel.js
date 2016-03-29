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
         * @returns {studentModel_L19.studentModel.studentModelAnonym$3}
         */
        function studentModel($http, $resource) {

            var _model;
            
            /**
             * Leaves only id property for sub level objects
             * required by Doctrine to work
             * @param {type} data
             * @returns {Array}
             */
            function cleanData(data) {
                var level = 0;
                function copy(o) {
                    var _out, v, _key;
                    _out = Array.isArray(o) ? [] : {};
                    for (_key in o) {
                        v = o[_key];
                        if (typeof v === "object" && v !== null) {
                            level++;
                            _out[_key] = copy(v);
                            level--;
                        } else {
                            if (!level) {
                                _out[_key] = v;
                            } else {
                                if (_key === 'id') {
                                    _out[_key] = v;
                                }
                            }
                        }
                    }
                    return _out;
                }
                return copy(data);
            }

            _model = $resource(
                window.LisGlobals.RestUrl + 'student/:id',
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
                    return _model.update({ id:id }, cleanData(data)).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Delete: function (id) {
//                    return _model.delete({ id:id }, data).$promise;
                }
            };
        }
        studentModel.$inject = ['$http', '$resource'];
        return studentModel;
    });

}(define, window));
/* 
 * 
 * LIS development
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2016 Lis dev team
 * @license    TODO
 * 
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
         * @return {gradingTypeModel_L6.gradingTypeModel.gradingTypeModelAnonym$3}
         */
        function gradingTypeModel($http, $resource) {

            var _gradingType;

            _gradingType = $resource(
                window.LisGlobals.RestUrl + 'gradingType/:id',
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
                    return _gradingType.query(params).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @return {unresolved}
                 */
                Get: function (id) {
                    return _gradingType.get({id: id}).$promise;
                },
                /**
                 * 
                 * @param {type} data
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Create: function (data) {
                    return _gradingType.save(data).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @return {undefined}
                 */
                Update: function (id, data) {
                    //TODO
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
        gradingTypeModel.$inject = ['$http', '$resource'];
        return gradingTypeModel;
    });

}(define, window));

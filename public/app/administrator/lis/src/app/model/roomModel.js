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

    define([], function () {

        /**
         * 
         * @param {type} $http
         * @param {type} $resource
         * @return {gradeChoiceModel_L6.gradeChoiceModel.gradeChoiceModelAnonym$3}
         */
        function roomModel($http, $resource) {

            var _roomChoice;

            _roomChoice = $resource(
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
                 * @param {type} params
                 * @return {unresolved}
                 */
                GetList: function (params) {
                    return _room.query(params).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @return {unresolved}
                 */
                Get: function (id) {
                    return _room.get({id: id}).$promise;
                },
                /**
                 * 
                 * @param {type} data
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Create: function (data) {
                    return _room.save(data).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @return {undefined}
                 */
                Update: function (id, data) {
                    return _room.update({id: id}, data).$promise;

                },
                /**
                 * 
                 * @param {type} id
                 * @return {undefined}
                 * @return {unresolved}
                 */
                Delete: function (id) {
                    return _room.delete({id: id}).$promise;
                }
            };
        }
        roomModel.$inject = ['$http', '$resource'];
        return roomModel;
    });

}(define, window));


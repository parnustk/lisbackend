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

    define([
        'app/util/globalFunctions',
        'moment'
    ], function (globalFunctions, moment) {

        /**
         * 
         * @param {type} $http
         * @param {type} $resource
         * @returns {contactLessonModel_L19.contactLessonModel.contactLessonModelAnonym$3}
         */
        function contactLessonModel($http, $resource) {

            var _model;

            _model = $resource(
                window.LisGlobals.RestUrl + 'contactLesson/:id',
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
                    return _model.save(globalFunctions.cleanData(data)).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @return {undefined}
                 */
                UpdateRegular: function (id, data) {
                    var d = globalFunctions.cleanData(data);
                    return _model.update({id: id}, d).$promise;
                },
                /**
                 * 
                 * @param {type} id
                 * @param {type} data
                 * @return {undefined}
                 */
                Update: function (id, data) {
                    var d = globalFunctions.cleanData(data);
                    delete d.studentGrade;//batch mapped by
                    delete d.absence;//batch mapped by
                    d.lessonDate = moment(data.lessonDate.date).format();
                    return _model.update({id: id}, d).$promise;
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
        contactLessonModel.$inject = ['$http', '$resource'];
        return contactLessonModel;
    });

}(define, window));
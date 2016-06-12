/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

/* global define */
/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

/**
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
            function (angular, globalFunctions, moment) {

                userDataController.$inject = [
                    '$scope',
                    '$q',
                    '$cookies',
                    'lisUserModel'
                ];

                function userDataController(
                        $scope,
                        $q,
                        $cookies,
                        lisUserModel) {

                    $scope.T = globalFunctions.T;
                    
                    $scope.userData = {};

                    /**
                     * Update logic
                     * 
                     * @param {type} rowEntity
                     * @returns {undefined}
                     */                    
                    $scope.ChangeData = function (valid) {
                        if(valid) {
                            var deferred = $q.defer();
                            //do auth request - see loginController,  use entered current pasword and seprately saved emadil
                            
                            //if auth success update user model if password
                            
                        }
//                        var deferred = $q.defer();
//                        lisUserModel.Update(rowEntity.id, rowEntity).then(
//                                function (result) {
//                                    if (result.success) {
//                                        deferred.resolve();
//                                    } else {
//                                        deferred.reject();
//                                    }
//                                }
//                        );
                    };

                    
                    /**
                     * Before loading lisUser data, 
                     * we first load relations and check success
                     * 
                     * @param {type} id
                     * @returns {undefined}
                     */                    
                    function LoadDataUser(id) {

                        lisUserModel.Get(id).then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                if(result.success) {
                                    //current email save seprately
                                    console.log(result.data);
                                }
                            }
                        });
                    }
                    
                    var lisUser, cRaw = $cookies.getObject('userObj');
                    if (cRaw) {
                        var uInf = angular.fromJson(cRaw);
                        if (uInf.hasOwnProperty('lisPerson')) {
                            lisUser = uInf.lisUser;
                            LoadDataUser(lisUser);
                        }
                    }
                    
                }

                return userDataController;
            });

}(define, document));

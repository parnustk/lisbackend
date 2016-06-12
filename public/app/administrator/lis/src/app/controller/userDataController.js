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
 * @author Sander Mets <sandermets0@gmail.com>
 */

/**
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define) {
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
                'lisUserModel',
                'loginModel'
            ];

            function userDataController(
                $scope,
                $q,
                $cookies,
                lisUserModel,
                loginModel) {

                var currentEmail;//auth purposes

                $scope.T = globalFunctions.T;

                $scope.userData = {};

                /**
                 * Update logic
                 * 
                 * @param {type} rowEntity
                 * @returns {undefined}
                 */
                $scope.ChangeData = function (valid) {
                    
                    if (valid) {

                        var updateData = {},
                            password = $scope.userData.password,
                            email = $scope.userData.email;

                        if (password) {
                            if (!(/((?=.*\d)(?=.*[a-zA-Z]).{8,20})/.test(password))) {
                                globalFunctions.alertErrorMsg($scope.T('LIS_PASSWORD_REQUIREMENTS'));
                                return;
                            }
                            updateData.password = password;
                        }
                        
                        if (email) {
                            if (currentEmail !== email) {
                                updateData.email = email;
                            }
                        }

                        if (updateData.hasOwnProperty('password') || updateData.hasOwnProperty('email')) {

                            lisUserModel.Update(lisUser, updateData)
                                .then(function (result) {
                                    if (globalFunctions.resultHandler(result)) {
                                        globalFunctions.alertSuccessMsg($scope.T('LIS_USER_DATA_SUCCESSFULLY_CHANGED'));
                                    } else {
                                        globalFunctions.alertErrorMsg($scope.T('LIS_USER_DATA_CHANGE_ERROR'));
                                    }
                                });

                        }

                    } else {
                        globalFunctions.alertErrorMsg($scope.T('LIS_CHECK_FORM_FIELDS'));
                    }
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
                            if (result.success) {
                                //current email save seprately
                                currentEmail = result.data.email;
                                $scope.userData.email = currentEmail;
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

}(define));

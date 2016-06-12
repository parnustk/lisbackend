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
                    'lisUserModel',
                    'loginModel'
                ];

                function userDataController(
                        $scope,
                        $q,
                        $cookies,
                        lisUserModel,
                        loginModel) {

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
                            var deferred = $q.defer();
                            var password = $scope.password;
                            if (password)//if password is not empy
                            {
                                if (!/((?=.*\d)(?=.*[a-zA-Z]).{8,20})/.test($scope.credentialsReg.confirmPassword)) {
                                    globalFunctions.alertErrorMsg($scope.T('LIS_PASSWORD_REQUIREMENTS'));
                                    return;
                                }
                            }
                            
                            var email = $scope.userData.email;
                            delete $scope.userData.passwordRepeat;
                            lisUserModel.Update(lisUser, $scope.userData)
                                    .then(function (result) {
                                        if (globalFunctions.resultHandler(result)) {
                                            globalFunctions.alertSuccessMsg($scope.T('LIS_USER_DATA_SUCCESSFULLY_CHANGED'));
                                        } else {
                                            globalFunctions.alertErrorMsg($scope.T('LIS_USER_DATA_CHANGE_ERROR'));
                                        }
                            });
                        } else {
                            globalFunctions.alertErrorMsg($scope.T('LIS_CHECK_FORM_FIELDS'));
                        }
                    };

                    var currentEmail;
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

}(define, document));

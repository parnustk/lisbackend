/**
 * Licence of Learning Info System (LIS)
 * 
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE
 */


/* global define */

/**
 *
 * @param {type} define
 * @returns {undefined}
 * @author Sander Mets <sandermets0@gmail.com>
 * @author Alar Aasa <alar@alaraasa.ee>
 * @author Juhan Kõks <juhankoks@gmail.com>
 * @author Eleri Apsolon <eleri.apsolon@gmail.com>
 */
(function (define) {
    'use strict';

    define(['angular', 'jquery', 'app/util/globalFunctions'], function (angular, $, globalFunctions) {

        loginController.$inject = ['$scope', 'loginModel', '$cookies', 'registerModel'];

        function loginController($scope, loginModel, $cookies, registerModel) {

            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate() + 5); //current date + x hours - the expire date of timed cookies

            $scope.T = globalFunctions.T;

            $scope.userLoginError = false;
            $scope.userRegisterError = false;

            $scope.credentials = {
                email: null,
                password: null,
                lisPerson: null,
                lisUser: null,
                role: "student",
                vocationId: null
            };

            $scope.keys = [];

            /**
             *
             * @param itemKey
             * @param itemValue
             */
            function addCookie(itemKey, itemValue) {
                $cookies.putObject(itemKey, itemValue); //these cookies never expire
            }

            /**
             *
             * @param itemKey
             * @param itemValue
             */
            function addCookieTimed(itemKey, itemValue) {

                $cookies.putObject(itemKey, itemValue, {'expires': expireDate}); //these cookies expire at expireDate
            }

            /**
             *
             * @param itemKey
             */
            function getCookie(itemKey) {
                $scope.currentItem = $cookies.get(itemKey); //gets the cookie object
            }

            /**
             *
             * @param itemKey
             * @returns {*}
             */
            function getCookieValue(itemKey) {
                return $cookies.getObject(itemKey); //gets just the cookie value
            }

            /**
             *
             * @param itemKey
             */
            function removeCookie(itemKey) {
                $cookies.remove(itemKey);
            }

            /**
             * 
             * @param {type} result
             * @returns {undefined}
             */
            function setUserInfo(result) {
                $scope.credentials.lisPerson = result.lisPerson;
                $scope.credentials.lisUser = result.lisUser;
                $scope.credentials.role = result.role;

                addCookie('userObj', angular.toJson({
                    lisPerson: result.lisPerson,
                    lisUser: result.lisUser,
                    role: result.role
                }));

                $scope.userLoginError = false;
                $scope.userLoggedIn = true;

                $('#user-greeting').show();
            }

            /**
             * 
             * @returns {undefined}
             */
            function clearUserInfo() {
                removeCookie('userObj');
                $scope.userLoggedIn = false;
                $scope.userLoginError = false;
                $('#user-greeting').hide();
                window.location.href = "#!/";
            }

            /**
             * 
             * @returns {undefined}
             */
            function clearUserInfoLogin() {
                removeCookie('userObj');
                $scope.userLoggedIn = false;
                $scope.userLoginError = true;
                $('#user-greeting').hide();
            }

            /**
             *
             * @param lang
             */
            $scope.changeLanguage = function (lang) {
                addCookie('userLang', lang);
                window.LisGlobals.L = lang;
            };

            /**'
             * @description Used in ng-show and ng-hide for the language buttons. Because this is a function, the page doesn't need to be refreshed after running changeLanguage();
             * @returns {boolean}
             */
            $scope.showButton = function () {
                var lang = getCookieValue('userLang');
                if (lang === 'et') {
                    return true;
                } else if (lang === 'en') {
                    return false;
                } else {
                    console.log('Language button display error. Possible cookie error.');
                }
            };

            $scope.Login = function () {
                loginModel
                    .Create($scope.credentials)
                    .then(function (result) {
                        if (result.success) {
                            //GOOD
                            $scope.credentials.lisPerson = result.lisPerson;
                            $scope.credentials.lisUser = result.lisUser;
                            $scope.credentials.role = result.role;
                            $scope.credentials.role = result.role;

                            addCookie('userObj', $scope.credentials.lisUser);

                            $scope.userLoginError = false;
                            $scope.userLoggedIn = true;
                        } else {
                            //BAD

                            $scope.userLoggedIn = false;
                            $scope.userLoginError = true;
                        }
                    });
            };

            $scope.Logout = function () {
                //console.log("Logout");
                window.location.href = "#!/"; //for firefox
                loginModel.Delete(1);
                removeCookie('userObj');
                window.location.reload();
            };

            //start register new user logic
            $scope.credentialsReg = {};

            /**
             * 
             * @param {Boolean} valid
             * @returns {undefined}
             */
            $scope.Register = function (valid) {
                if (valid) {
                    if (!/((?=.*\d)(?=.*[a-zA-Z]).{8,20})/.test($scope.credentialsReg.confirmPassword)) {
                        globalFunctions.alertErrorMsg($scope.T('LIS_PASSWORD_REQUIREMENTS'));
                        $scope.credentialsReg.password = '';
                        $scope.credentialsReg.confirmPassword = '';
                        return;
                    }

                    delete $scope.credentialsReg.confirmPassword;
                    registerModel
                        .Create($scope.credentialsReg)
                        .then(function (result) {
                            if (globalFunctions.resultHandler(result)) {
                                $scope.credentialsReg.email = '';
                                $scope.credentialsReg.password = '';
                                $scope.credentialsReg.password = '';
                                $scope.credentialsReg.password = '';
                                $scope.credentialsReg.confirmPassword = '';
                                globalFunctions.alertSuccessMsg($scope.T('LIS_YOU_CAN_LOGIN_NOW'));
                            }
                        });
                } else {
                    globalFunctions.alertErrorMsg($scope.T('LIS_CHECK_FORM_FIELDS'));
                }
            };

            var ferole = '-', cRaw = $cookies.getObject('userObj');
            if (cRaw) {
                var uInf = angular.fromJson(cRaw);
                if (uInf.hasOwnProperty('role')) {
                    ferole = uInf.role;
                }
            }

            //check BE session
            loginModel
                .GetList({ferole: ferole})
                .then(function (result) {
                    result.success ? setUserInfo(result) : clearUserInfo();
                });

            //check language
            typeof getCookieValue('userLang') === 'undefined' ?
                addCookie('userLang', window.LisGlobals.L) :
                window.LisGlobals.L = getCookieValue('userLang');
        }

        return loginController;
    });

}(define));

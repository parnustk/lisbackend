/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

/**
 *
 * @param {type} define
 * @returns {undefined}
 * @author Sander Mets <sandermets0@gmail.com>, Alar Aasa <alar@alaraasa.ee>, Juhan Kõks <juhankoks@gmail.com>
 */
(function (define) {
    'use strict';

    define(['app/util/globalFunctions'], function (globalFunctions) {


        loginController.$inject = ['$scope', 'loginModel', '$cookies', 'registerModel'];

        function loginController($scope, loginModel, $cookies, registerModel) {

            $scope.credentials = {
                email: 'teacher@test.ee',
                password: 'Tere1234',
                lisPerson: null,
                lisUser: null,
                role: "teacher"
            };

            $scope.keys = [];

            /**cookies**/

            /**
             *
             * @type {Date}
             */
            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate() + 5); //current date + x hours - the expire date of timed cookies

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

            $scope.T = globalFunctions.T;



            $scope.Login = function () {
                loginModel
                        .Create($scope.credentials)
                        .then(function (result) {
                            if (result.success) {
                                //GOOD
                                $scope.credentials.lisPerson = result.lisPerson;
                                $scope.credentials.lisUser = result.lisUser;
                                $scope.credentials.role = result.role;
                                addCookie('userObj', $scope.credentials.role);

                                $scope.userLoginError = false;
                                $scope.userLoggedIn = true;
                            } else {
                                //BAD

                                $scope.userLoggedIn = false;
                                $scope.userLoginError = true;
                            }
                        });
            };

            /**
             * If a cookie exists, that means that there has been a successful login.
             * Then we update the cookie to extend the expiration date.
             */
            if (getCookieValue('userObj') !== undefined) {
                $scope.userLoggedIn = true;
                addCookie('userObj', $scope.credentials.role);
            }

            if (getCookieValue('userLang') === undefined) {
                var currentLang = window.LisGlobals.L;
                addCookie('userLang', currentLang);
            } else if (getCookieValue('userLang') === 'et') {
                window.LisGlobals.L = 'et';
            } else if (getCookieValue('userLang') === 'en') {
                window.LisGlobals.L = 'en';
            } else {
                console.log('ERROR in Login/Language Change. Possible cookie error.');
            }

            /** /cookies **/


            $scope.Logout = function () {
                //console.log("Logout");
                window.location.href = "#!/"; //for firefox
                loginModel.Delete(1);
                removeCookie('userObj');
                window.location.reload();
            };


            $scope.credentialsReg = {};
            /**
             *
             * @param valid
             * @constructor
             */
            $scope.Register = function (valid) {
                if (valid) {
                    if(!/((?=.*\d)(?=.*[a-zA-Z]).{8,20})/.test($scope.credentialsReg.confirmPassword)) {
                        globalFunctions.alertErrorMsg('LIS_PASSWORD_REQUIREMENTS');

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
                                $scope.credentialsReg.confirmPassword = '';
                                globalFunctions.alertSuccessMsg('LIS_YOU_CAN_LOGIN_NOW');
                            }
                        });
                } else {
                    globalFunctions.alertErrorMsg('LIS_CHECK_FORM_FIELDS');
                }
            };


        }

        return loginController;
    });

}(define));
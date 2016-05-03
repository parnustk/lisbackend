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
 * @author Sander Mets <sandermets0@gmail.com>, Alar Aasa <alar@alaraasa.ee>
 */
(function (define) {
    'use strict';

    define(['app/util/globalFunctions'], function (globalFunctions) {


        loginController.$inject = ['$scope', 'loginModel', '$cookies'];

        function loginController($scope, loginModel, $cookies) {

            $scope.credentials = {
                email: 'admin@test.ee',
                password: 'Tere1234'
            };

            $scope.keys = [];

            /**cookies**/

            /**
             *
             * @type {Date}
             */
            var expireDate = new Date();
            expireDate.setDate(expireDate.getDate()+5); //current date + x hours - the expire date of timed cookies

            /**
             *
             * @param itemKey
             * @param itemValue
             */
            function addCookie (itemKey, itemValue){
                $cookies.putObject(itemKey, itemValue); //these cookies never expire
            }

            /**
             *
             * @param itemKey
             * @param itemValue
             */
            function addCookieTimed (itemKey, itemValue){

                $cookies.putObject(itemKey, itemValue, {'expires': expireDate}); //these cookies expire at expireDate
            }

            /**
             *
             * @param itemKey
             */
            function getCookie (itemKey) {
                $scope.currentItem = $cookies.get(itemKey); //gets the cookie object
            }

            /**
             *
             * @param lang
             */
            $scope.changeLanguage = function(lang){
                addCookie('userLang', lang);
                window.LisGlobals.L = lang;
            };

            /**'
             * @description Used in ng-show and ng-hide for the language buttons. Because this is a function, the page doesn't need to be refreshed after running changeLanguage();
             * @returns {boolean}
             */
            $scope.showButton = function(bool){
                var lang = getCookieValue('userLang');

                if (lang === 'et') {
                    return true;
                } else if (lang === 'en') {
                    return false;
                } else {
                    console.log('Language button display error. Possible cookie error.');
                }

                if (bool) {
                    window.location = window.location;
                }
            };

            /**
             *
             * @param itemKey
             * @returns {*}
             */
            function getCookieValue (itemKey){
                return $cookies.getObject(itemKey); //gets just the cookie value
            }

            /**
             *
             * @param itemKey
             */
            function removeCookie (itemKey){
                $cookies.remove(itemKey);
            }

            $scope.T = globalFunctions.T;

            

            $scope.Login = function () {
                loginModel
                    .Create($scope.credentials)
                    .then(function (result) {
                        if (result.success) {
                            //GOOD

                            addCookieTimed('userObj', $scope.credentials);

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
                //var loginData = getCookieValue('userObj');
                $scope.userLoggedIn = true;

                //this gives some HTML error in console, but seems harmless otherwise, doesn't actually break anything
                // $scope.credentials = {
                //     email: loginData.email,
                //     password: loginData.password
                // };
                // $scope.Login();

                addCookieTimed('userObj', $scope.credentials);
                // $scope.Login(); //error

            }


            if (getCookieValue('userLang') === undefined) {
                var currentLang = window.LisGlobals.L;
                addCookie('userLang', currentLang);
                $scope.langEt = true;
            } else if (getCookieValue('userLang') === 'et') {
                window.LisGlobals.L = 'et';
                $scope.langEt = true;
            } else if (getCookieValue('userLang') === 'en') {
                window.LisGlobals.L = 'en';
                $scope.langEt = false;
            } else {
                console.log('ERROR in Login/Language Change. Possible cookie error.');
            }

            /** /cookies **/


            $scope.Logout = function() {
                //console.log("Logout");
                window.location.href = "#!/"; //for firefox
                loginModel.Delete(1);
                removeCookie('userObj');
                window.location.reload();
            };
        }

        return loginController;
    });

}(define));
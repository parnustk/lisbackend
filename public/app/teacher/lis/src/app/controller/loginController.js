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
             * We get the JSON data from the cookie, put the data into credentials.
             * Then we update the cookie to extend the expiration date.
             */
            if (getCookieValue('userObj') !== undefined) {
                //var loginData = getCookieValue('userObj');
                $scope.userLoggedIn = true;
                // $scope.credentials = {
                //     email: loginData.email,
                //     password: loginData.password
                // };
                var lang = {
                    lang: 'et'
                };
                addCookieTimed('userObj', $scope.credentials);
                // $scope.Login(); //error

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
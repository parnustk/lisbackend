/*global require*/
'use strict';

require(['angular'], function (angular) {

    angular.module('Admin').controller('HomeController', [
        '$scope',
        function ($scope) {
            alert('Inside module!!');
        }
    ]);
});



/* global GlobalConf, adminModule */

(function (angular, GlobalConf) {
    "use strict";

    define(['module/models'], function () {

        var adminModule = angular.module('adminModule');

        adminModule.config(['$controllerProvider', function ($controllerProvider) {
                adminModule.registerController = $controllerProvider.register;
            }]);

        adminModule.config(['$routeProvider', function ($routeProvider) {

                $routeProvider.when('/', {
                    controller: 'mainController',
                    templateUrl: '/view/admin/main.html',
                    resolve: {
                        load: ['$q', function ($q) {
                                var deferred = $q.defer();
                                require(
                                        [GlobalConf.BaseUrl + 'module/controller/mainController'],
                                        function () {
                                            deferred.resolve();
                                        });
                                return deferred.promise;
                            }]
                    }
                });

                $routeProvider.when('/vocation', {
                    controller: 'vocationController',
                    templateUrl: '/view/admin/vocation.html',
                    resolve: {
                        load: ['$q', function ($q) {
                                var deferred = $q.defer();
                                require(
                                        [GlobalConf.BaseUrl + 'module/controller/vocationController'],
                                        function () {
                                            deferred.resolve();
                                        });
                                return deferred.promise;
                            }]
                    }
                });

                $routeProvider.when('/diary', {
                    controller: 'diaryController',
                    templateUrl: '/view/admin/diary.html',
                    resolve: {
                        load: ['$q', function ($q) {
                                var deferred = $q.defer();
                                require(
                                        [GlobalConf.BaseUrl + 'module/controller/diaryController'],
                                        function () {
                                            deferred.resolve();
                                        });
                                return deferred.promise;
                            }]
                    }
                });

            }]);

        return undefined;
    });


}(angular, GlobalConf));




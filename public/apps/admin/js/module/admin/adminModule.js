/* global GlobalConf */

define(function () {

    var adminModule = angular.module('adminModule', ['ngRoute', 'ngResource']);

    adminModule.config(['$controllerProvider', function ($controllerProvider) {
            adminModule.registerController = $controllerProvider.register;
        }]);

    adminModule.factory("VocationModel", function ($resource) {
        return $resource(
                "http://lis.localhost/admin/vocation/:Id",
                {id: "@Id"},
        {
            "update": {method: "PUT"},
            "reviews": {'method': 'GET', 'params': {'reviews_only': "true"}, isArray: true}

        }
        );
    });


    //Router - the application executes based on URL. Uses Lazyload
    adminModule.config(['$routeProvider', function ($routeProvider) {

            $routeProvider.when('/', {
                controller: 'mainController',
                templateUrl: '/view/admin/main/main.html',
                resolve: {
                    load: ['$q', function ($q) {
                            var deferred = $q.defer();
                            require(
                                    [GlobalConf.BaseUrl + 'module/admin/controller/mainController'],
                                    function () {
                                        deferred.resolve();
                                    });
                            return deferred.promise;
                        }]
                }
            });

            $routeProvider.when('/vocation', {
                controller: 'vocationController',
                templateUrl: '/view/admin/vocation/vocation.html',
                resolve: {
                    load: ['$q', function ($q) {
                            var deferred = $q.defer();
                            require(
                                    [GlobalConf.BaseUrl + 'module/admin/controller/vocationController'],
                                    function () {
                                        deferred.resolve();
                                    });
                            return deferred.promise;
                        }]
                }
            });

        }]);


    angular.bootstrap(document, ['adminModule']);
});
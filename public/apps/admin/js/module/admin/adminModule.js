define(function () {

    var adminModule = angular.module('adminModule', ['ngRoute']);

    adminModule.config(['$controllerProvider', function ($controllerProvider) {
            adminModule.registerController = $controllerProvider.register;
        }]);

    //Router - the application executes based on URL. Uses Lazyload
    adminModule.config(['$routeProvider', function ($routeProvider) {
            $routeProvider.when('/', {
                controller: 'mainController',
                templateUrl: '/view/admin/main/main.html',
                resolve: {
                    load: ['$q', function ($q) {
                            var deferred = $q.defer();
                            require(['module/admin/controller/mainController'], function () {
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
                            require(['module/admin/controller/vocationController'], function () {
                                deferred.resolve();
                            });
                            return deferred.promise;
                        }]
                }
            });
        }]);
    

    angular.bootstrap(document, ['adminModule']);
});
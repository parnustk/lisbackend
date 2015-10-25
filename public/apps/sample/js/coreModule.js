define(function () {

    var coreModule = angular.module('coreModule', ['ngRoute']);

    coreModule.config(['$controllerProvider', function ($controllerProvider) {
            coreModule.registerController = $controllerProvider.register;
        }]);

    coreModule.config(['$routeProvider', function ($routeProvider) {
            $routeProvider
                    .when('/', {
                        controller: 'homeController',
                        templateUrl: '/views/modules/admin/home/home.html'
                    })
                    .when('/home', {
                        controller: 'homeController',
                        templateUrl: '/views/modules/admin/home/home.html',
                        resolve: {
                            load: ['$q', function ($q) {
                                    var deferred = $q.defer();
                                    require(['modules/admin/controller/home'], function () {
                                        deferred.resolve();
                                    });
                                    return deferred.promise;
                                }]
                        }
                    });
        }]);

    require([
        'modules/admin/controller/main'
    ], function () {
        angular.bootstrap(document, ['coreModule']);
    });
});
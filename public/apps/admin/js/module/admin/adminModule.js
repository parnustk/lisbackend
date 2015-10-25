/* global GlobalConf */

/**
 * Main entry point to app
 * @returns {undefined}
 */
define(function () {

    /**
     * Init angular module
     * @type @exp;angular@call;module
     */
    var adminModule = angular.module('adminModule', [
        'ngRoute',
        'ngResource',
        'ngTouch',
        'ui.grid',
        'ui.grid.edit',
        'ui.grid.cellNav',
        'ui.grid.saveState', 
        'ui.grid.selection', 
        'ui.grid.cellNav', 
        'ui.grid.resizeColumns', 
        'ui.grid.moveColumns', 
        'ui.grid.pinning', 
        'ui.grid.grouping'
    ]);

    /**
     * setup for Lazyload
     */
    adminModule.config(['$controllerProvider', function ($controllerProvider) {
            adminModule.registerController = $controllerProvider.register;
        }]);

    /**
     * Models: TODO think of separate model files
     */
    adminModule.factory("VocationModel", function ($resource) {
        return $resource(
                "http://lis.localhost/admin/vocation/:Id",
                {id: "@Id"},
        {
            "update": {method: "PUT"},
            'query': {method: 'GET', isArray: false},
            "reviews": {'method': 'GET', 'params': {'reviews_only': "true"}, isArray: true}

        }
        );
    });

    /**
     * Router - the application executes based on URL. Uses Lazyload
     */
    adminModule.config(['$routeProvider', function ($routeProvider) {

            $routeProvider.when('/', {
                controller: 'mainController',
                templateUrl: '/view/admin/main.html',
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
                templateUrl: '/view/admin/vocation.html',
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
            
            $routeProvider.when('/diary', {
                controller: 'diaryController',
                templateUrl: '/view/admin/diary.html',
                resolve: {
                    load: ['$q', function ($q) {
                            var deferred = $q.defer();
                            require(
                                    [GlobalConf.BaseUrl + 'module/admin/controller/diaryController'],
                                    function () {
                                        deferred.resolve();
                                    });
                            return deferred.promise;
                        }]
                }
            });

        }]);

    /**
     * Start the god damn app
     */
    angular.bootstrap(document, ['adminModule']);
});
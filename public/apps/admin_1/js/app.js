/*global require*/
'use strict';

require(['angular', 'angularRoute', 'angularCookies'],
        function (angular, angularRoute, angularCookies) {

            require([
                'modules/home/HomeController'
            ], function (HomeController) {
                console.log(HomeController);
                angular.module('Authentication', []);
                angular.module('Home', []);

                var document = document || {};
                var app = angular.module('Admin', [
                    'Authentication',
                    'Home',
                    'ngRoute',
                    'ngCookies'
                ]);
                app.controller('HomeController', HomeController);

                app.config(['$routeProvider', function ($routeProvider) {
                        $routeProvider
                                .when('/', {
                                    controller: 'HomeController',
                                    templateUrl: 'home/home.html',
                                    controllerAs: 'vm'
                                })

//                            .when('/login', {
//                                controller: 'LoginController',
//                                templateUrl: 'login/login.view.html',
//                                controllerAs: 'vm'
//                            })
//
//                            .when('/register', {
//                                controller: 'RegisterController',
//                                templateUrl: 'register/register.view.html',
//                                controllerAs: 'vm'
//                            })

                                .otherwise({redirectTo: '/login'});
                    }]);


                app.run(['$rootScope', '$location', '$cookieStore', '$http',
                    function ($rootScope, $location, $cookieStore, $http) {
                        console.log('Globals', $cookieStore.get('globals'));
                        $location.path('/');
                        // keep user logged in after page refresh
//                    $rootScope.globals = $cookieStore.get('globals') || {};
//                    if ($rootScope.globals.currentUser) {
//                        $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
//                    }
//
//                    $rootScope.$on('$locationChangeStart', function (event, next, current) {
//                        // redirect to login page if not logged in
//                        if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
//                            $location.path('/login');
//                        }
//                    });
                    }]);

                angular.bootstrap(document, ['Admin']);

            });



        });



//require([
//    'angular'
//], function (angular) {
//    require([
//        'controllers/todo',
//        'directives/todoFocus',
//        'directives/todoEscape',
//        'services/todoStorage'
//    ], function (todoCtrl, todoFocusDir, todoEscapeDir, todoStorageSrv) {
//        angular
//                .module('todomvc', [todoFocusDir, todoEscapeDir, todoStorageSrv])
//                .controller('TodoController', todoCtrl);
//        angular.bootstrap(document, ['todomvc']);
//
//    });
//});

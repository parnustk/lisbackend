(function (angular) {

    define(function () {

        var adminModule = angular.module('adminModule');

        adminModule.registerController('mainController', ['$scope', function ($scope) {
                $scope.title = 'Kodu';
            }]);

        return undefined;
    });

}(angular));




define(function () {

    var coreModule = angular.module('coreModule');
    coreModule.registerController('homeController', ['$scope', function ($scope) {
            $scope.title = 'Home';
        }]);

});
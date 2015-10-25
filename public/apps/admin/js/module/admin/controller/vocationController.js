define(function () {
    angular.module('adminModule').registerController(
            'vocationController', ['$scope', 'VocationModel',
                function ($scope, VocationModel) {
                    
                    var vocation = VocationModel.get({},{'Id': 1});
                    
                    console.log(vocation);
                    console.log(vocation.data);
                    $scope.title = 'Erialad';

                }
            ]);
});



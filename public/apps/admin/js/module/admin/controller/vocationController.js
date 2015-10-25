define(function () {
    angular.module('adminModule').registerController(
            'vocationController', ['$scope', 'VocationModel',
                function ($scope, VocationModel) {

                    var vocation = VocationModel.get({}, {'Id': 1}, function (data) {
                        console.log(data);
                        if (data.success) {
                            console.log(data.data);
                        } else {
                            alert('error');
                        }
                    });
                    $scope.title = 'Erialad';
                }
            ]);
});



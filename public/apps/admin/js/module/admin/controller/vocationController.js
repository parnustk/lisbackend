define(function () {
    angular.module('adminModule').registerController(
            'vocationController', ['$scope', 'VocationModel',
                function ($scope, VocationModel) {
                    //good one http://stackoverflow.com/questions/25070690/angularjs-handling-resource-promise-errors
                    $scope.gridOptions = {enableCellEditOnFocus: true};

                    $scope.gridOptions.columnDefs = [
                        {name: 'id', visible: false, enableCellEdit: false, width: '10%'},
                        {name: 'name', enableCellEdit: true, width: '10%'},
                        {name: 'code', enableCellEdit: true},
                        {name: 'durationEKAP', type: 'number', enableCellEdit: true}
                    ];

                    VocationModel.query({tere: 12}, function (data) {
                        console.log(data);
                        if (data.success) {
                            $scope.gridOptions.data = data.data;
                        } else {
                            alert('error');
                        }
                    });
                    $scope.title = 'Erialad';

                    $scope.editMessage = {};

                    $scope.gridOptions.onRegisterApi = function (gridApi) {
                        //set gridApi on scope
                        $scope.gridApi = gridApi;
                        gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
                            $scope.editMessage.lastCellEdited = 'edited row id:' + rowEntity.id + ' Column:' + colDef.name + ' newValue:' + newValue + ' oldValue:' + oldValue;
                            $scope.$apply();

//                            var vocation = VocationModel.get({id: rowEntity.id});

      
                            VocationModel.update({id: rowEntity.id}, rowEntity);

                        });
                    };


                }
            ]);
});



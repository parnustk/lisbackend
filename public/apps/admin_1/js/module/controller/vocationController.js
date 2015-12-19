(function (angular) {

    define(function () {

        angular.module('adminModule').registerController(
                'vocationController',
                ['$scope', 'VocationModel',
                    function ($scope, VocationModel) {

                        //good one http://stackoverflow.com/questions/25070690/angularjs-handling-resource-promise-errors
                        //http://brianhann.com/6-ways-to-take-control-of-how-your-ui-grid-data-is-displayed/
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
                            $scope.state = {};

//                        $scope.saveState();

                            gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
                                $scope.editMessage.lastCellEdited =
                                        'edited row id:' + rowEntity.id +
                                        ' Column:' + colDef.name +
                                        ' newValue:' + newValue +
                                        ' oldValue:' + oldValue;

                                $scope.$apply();
                                VocationModel
                                        .update({id: rowEntity.id}, rowEntity)
                                        .$promise
                                        .then(function (data) {
                                            if (!data.success) {
                                                alert(data.message);
//                                            $scope.restoreState();
                                            } else {
//                                            $scope.saveState();
                                            }
                                        });
                            });
                        };

//                    $scope.saveState = function () {
//                        $scope.state = $scope.gridApi.saveState.save();
//                    };
//
//                    $scope.restoreState = function () {
//                        $scope.gridApi.saveState.restore($scope, $scope.state);
//                    };
//                    
                    }

                ]);

        return undefined;
    });

}(angular));




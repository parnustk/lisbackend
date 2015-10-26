/**
 * 
 * @param {type} moment
 * @returns {undefined}
 */
define(['moment'], function (moment) {

    angular.module('adminModule').registerController(
            'diaryController', ['$scope', 'VocationModel',
                function ($scope, VocationModel) {
                    console.log(moment());
                    //good one http://stackoverflow.com/questions/25070690/angularjs-handling-resource-promise-errors
                    //http://brianhann.com/6-ways-to-take-control-of-how-your-ui-grid-data-is-displayed/
                    $scope.gridOptions = {enableCellEditOnFocus: true};

                    $scope.dateArray = [
                        '12.12',
                        '13.12',
                        '14.12',
                        '15.12',
                        '16.12',
                        '17.12',
                        '18.12',
                        '19.12',
                        '20.12'
                    ];
                    $scope.columnDefs = [
                        {name: 'id', visible: false, enableCellEdit: false, width: '10%'},
                        {name: 'name', enableCellEdit: true, width: '10%'}
                    ];
                    for (var x in $scope.dateArray) {

                        $scope.columnDefs.push({
                            name: $scope.dateArray[x], enableCellEdit: true
                        });
                    }

                    $scope.gridOptions.columnDefs = $scope.columnDefs;

//                    function getDateRange(startDate, endDate, dateFormat) {
//                        var dates = [],
//                                end = moment(endDate),
//                                diff = endDate.diff(startDate, 'days');
//
//                        if (!startDate.isValid() || !endDate.isValid() || diff <= 0) {
//                            return;
//                        }
//
//                        for (var i = 0; i < diff; i++) {
//                            dates.push(end.subtract(1, 'd').format(dateFormat));
//                        }
//
//                        return dates;
//                    }
//                    var startDate = Date.today().clearTime().moveToFirstDayOfMonth();
//                    var endDate = Date.today().clearTime().moveToLastDayOfMonth();
//                    console.log(getDateRange(startDate, endDate, 'dd.mm.YYYY'));


                    VocationModel.query({tere: 12}, function (data) {
                        console.log(data);
                        if (data.success) {
                            $scope.gridOptions.data = data.data;
                        } else {
                            alert('error');
                        }
                    });
//                    $scope.title = 'Erialad';
//                    $scope.editMessage = {};
//
//
//                    $scope.gridOptions.onRegisterApi = function (gridApi) {
//                        //set gridApi on scope
//                        $scope.gridApi = gridApi;
//                        $scope.state = {};
//
////                        $scope.saveState();
//
//                        gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
//                            $scope.editMessage.lastCellEdited =
//                                    'edited row id:' + rowEntity.id +
//                                    ' Column:' + colDef.name +
//                                    ' newValue:' + newValue +
//                                    ' oldValue:' + oldValue;
//
//                            $scope.$apply();
//                            VocationModel
//                                    .update({id: rowEntity.id}, rowEntity)
//                                    .$promise
//                                    .then(function (data) {
//                                        if (!data.success) {
//                                            alert(data.message);
////                                            $scope.restoreState();
//                                        } else {
////                                            $scope.saveState();
//                                        }
//                                    });
//                        });
//                    };

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
});



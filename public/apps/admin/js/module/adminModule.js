

define([
    'angular',
    'angular-route',
    'angular-resource',
    'angular-ui-grid',
    'angular-touch'
], function (angular) {

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

    return adminModule;
});


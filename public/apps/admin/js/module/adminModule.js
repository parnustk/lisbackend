

/* global GlobalConf */

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

    adminModule.factory("VocationModel", function ($resource) {

        return $resource(
                GlobalConf.RestUrl + "vocation/:Id",
                {id: "@Id"},
                {
                    update: {method: "PUT"},
                    query: {method: 'GET', isArray: false},
                    reviews: {method: 'GET', params: {reviews_only: "true"}, isArray: true}

                }
        );
    });

    return adminModule;
});


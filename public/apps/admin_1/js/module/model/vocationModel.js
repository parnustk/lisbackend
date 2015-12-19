/* global GlobalConf */

(function (angular, GlobalConf) {
    
    "use strict";
    
    var adminModule = angular.module('adminModule');

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
    
}(angular, GlobalConf));



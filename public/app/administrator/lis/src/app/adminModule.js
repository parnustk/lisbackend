/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global define */

/**
 * 
 * @param {type} define
 * @returns {undefined}
 */
(function (define) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} config
     * @param {type} vocationModel
     * @param {type} vocationContoller
     * @returns {angular.module.angular-1_3_6_L1749.moduleInstance}
     */
    define([
        'angular',
        'app/config',
        'app/model/vocationModel',
        'app/controller/vocationContoller'
    ], function (
        angular,
        config,
        vocationModel,
        vocationContoller
        ) {

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

        adminModule.config(config);
        adminModule.factory('vocationModel', vocationModel);
        adminModule.controller('vocationController', vocationContoller);

        return adminModule;
    });

}(define));
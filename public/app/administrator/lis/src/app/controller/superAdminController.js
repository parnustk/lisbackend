/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

/* global define */
/**
 * 
 * @author Kristen Sepp <seppkristen@gmail.com>
 */

/**
 * 
 * @param {type} define
 * @param {type} document
 * @returns {undefined}
 */
(function (define, document) {
    'use strict';

    /**
     * 
     * @param {type} angular
     * @param {type} globalFunctions
     * @returns {independentWorkController_L21.independentWorkController_L32.independentWorkController}
     */
    define(['angular', 'app/util/globalFunctions', 'moment'],
        function (angular, globalFunctions, moment) {

            superAdminController.$inject = [
                '$scope', 
                '$q', 
                '$routeParams', 
                'rowSorter', 
                'uiGridConstants',
                'lisUserModel'
            ];

            function superAdminController(
                    $scope, 
                    $q, 
                    $routeParams, 
                    rowSorter, 
                    uiGridConstants, 
                    lisUserModel) {

                $scope.T = globalFunctions.T;
                
                /**
                 * For filters and maybe later pagination
                 * 
                 * @type type
                 */
                var urlParams = {
                    page: 1,
                    limit: 100000,
                    usermng: 'usermng'
                };

                $scope.lisUser = [];


                /**
                 * Before loading independentWork data, 
                 * we first load relations and check success
                 * 
                 * @returns {undefined}
                 */
                function LoadData() {

                    lisUserModel.GetList({}).then(function (result) {
                        if (globalFunctions.resultHandler(result)) {

                            $scope.lisUser = result.data;
    
                        }
                    });
                }

                LoadData();//let's start loading data
            }

            return superAdminController;
        });

}(define, document));

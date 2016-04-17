/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 * 
 * Licence of Learning Info System (LIS)
 * Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * You may use LIS for free, but you MAY NOT sell it without permission.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 */

/**
 * 
 * @param {Function} require
 * @param {Object} document
 * @returns {undefined}
 */
(function (require, document) {
    'use strict';

    require([
        'jquery',
        'bootstrap',
        'pdfmake',
        'angular-bootstrap'
    ], function ($, bootstrap, pdfmake, angularBootstrap) {
        $(document).ready(function () {//DOM loaded
            require([
                'angular',
                'angular-cookies',
                'angular-resource',
                'angular-route',
                'angular-sanitize',
                'angular-touch',
                'angular-ui-grid',
                'angular-ui-select'
            ], function (angular) {
                require(['app/adminModule'], function (adminModule) {
                    angular.bootstrap(document, ['adminModule']);
                });
            });
        });
    });

}(require, document));



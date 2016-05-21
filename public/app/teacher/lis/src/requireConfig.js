/*
 * LIS development
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://github.com/parnustk/lisbackend/blob/master/LICENSE.txt
 */

/**
 * !function(){}() <-> (function(){}())
 * @param {type} require
 * @returns {undefined}
 */
(function (require) {
    'use strict';

    /**
     * AMD dependancies
     * 
     * @param {Object} param
     */
    require.config({
        waitSeconds: 0,
        shim: {
            'what-input': [
                'jquery'
            ],
            'angular': {
                deps: ['moment'],
                exports: 'angular'
            },
            'bootstrap': {
                deps: ['jquery']
            },
            'bootbox': {
                deps: ['bootstrap']
            },
            'angular-cookies': [
                'angular'
            ],
            'angular-route': [
                'angular'
            ],
            'angular-resource': [
                'angular'
            ],
            'angular-touch': [
                'angular'
            ],
            'angular-bootstrap': {
                deps: [
                    'angular',
                    'angular-animate',
                    'angular-touch'
                ]
            },
            'angular-bootstrap-tpls': {
                deps: [
                    'angular-bootstrap'
                ]
            },
            'angular-animate': [
                'angular'
            ],
            'angular-ui-grid': [
                'angular'
            ],
            'angular-sanitize': [
                'angular'
            ],
            'angular-ui-select': [
                'angular'
            ],
            pdfMakeLib: {
                exports: 'pdfMake'
            },
            pdfmake: {
                deps: ['pdfMakeLib'],
                exports: 'pdfMake'
            }
        },
        catchError: {
            define: true
        },
        paths: {
            'moment': '../../bower_components/moment/min/moment.min',
            'angular': '../../bower_components/angular/angular',
            'angular-cookies': '../../bower_components/angular-cookies/angular-cookies',
            'angular-resource': '../../bower_components/angular-resource/angular-resource',
            'angular-route': '../../bower_components/angular-route/angular-route',
            'angular-sanitize': '../../bower_components/angular-sanitize/angular-sanitize',
            'angular-touch': '../../bower_components/angular-touch/angular-touch',
            'angular-ui-select': '../../bower_components/ui-select/dist/select',
            'angular-ui-grid': '../../bower_components/angular-ui-grid/ui-grid',
            'angular-animate': '../../bower_components/angular-animate/angular-animate',
            'jquery': '../../bower_components/jquery/dist/jquery',
            'bootstrap': '//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min',
            'angular-bootstrap': '../../bower_components/angular-bootstrap/ui-bootstrap',
            'angular-bootstrap-tpls': '../../bower_components/angular-bootstrap/ui-bootstrap-tpls',
            'what-input': '../../bower_components/what-input/what-input',
            'motion-ui': '../../bower_components/motion-ui/dist/motion-ui',
            'foundation': '../../bower_components/foundation-sites/dist/foundation',
            'pdfmake': '../../bower_components/pdfmake/build/vfs_fonts',
            'pdfMakeLib': '../../bower_components/pdfmake/build/pdfmake',
            'bootbox': '../../lis/lib/bootbox/bootbox.min',
            'bootstrapApp': 'bootstrapApp'
        },
        deps: [
            'bootstrapApp'
        ]
    });
}(require));
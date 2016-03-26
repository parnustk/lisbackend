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
            'foundation': {
                deps: ['jquery'],
                exports: "Foundation"
            },
            'angular': {
                exports: 'angular'
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
            'angular-ui-grid': [
                'angular'
            ],
            'angular-sanitize': [
                'angular'
            ],
            pdfMakeLib: {
                exports: 'pdfMake'
            },
            pdfmake: {
                deps: ['pdfMakeLib'],
                exports: 'pdfMake'
            },
        },
        catchError: {
            define: true
        },
        paths: {
            'angular': '../../bower_components/angular/angular',
            'angular-cookies': '../../bower_components/angular-cookies/angular-cookies',
            'angular-resource': '../../bower_components/angular-resource/angular-resource',
            'angular-route': '../../bower_components/angular-route/angular-route',
            'angular-sanitize': '../../bower_components/angular-sanitize/angular-sanitize',
            'angular-touch': '../../bower_components/angular-touch/angular-touch',
            'angular-ui-grid': '../../bower_components/angular-ui-grid/ui-grid',
            'jquery': '../../bower_components/jquery/dist/jquery',
            'what-input': '../../bower_components/what-input/what-input',
            'motion-ui': '../../bower_components/motion-ui/dist/motion-ui',
            'foundation': '../../bower_components/foundation-sites/dist/foundation',
            'pdfmake': '../../bower_components/pdfmake/build/vfs_fonts',
            'pdfMakeLib': '../../bower_components/pdfmake/build/pdfmake',
            'bootstrap': 'bootstrap'
        },
        deps: [
            'bootstrap'
        ]
    });
}(require));
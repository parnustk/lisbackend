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
            foundation: [
                'jquery',
                'what-input'
            ],
            'foundation-util-mediaQuery': [
                'foundation'
            ],
            'foundation-util-keyboard': [
                'foundation'
            ],
            'foundation-util-box': [
                'foundation'
            ],
            'foundation-util-nest': [
                'foundation'
            ],
            'foundation-dropdown': [
                'foundation-util-keyboard',
                'foundation-util-box',
                'foundation-util-nest'
            ],
            angular: {
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
            ]
        },
        paths: {
            angular: '../../bower_components/angular/angular',
            'angular-cookies': '../../bower_components/angular-cookies/angular-cookies',
            'angular-resource': '../../bower_components/angular-resource/angular-resource',
            'angular-route': '../../bower_components/angular-route/angular-route',
            'angular-sanitize': '../../bower_components/angular-sanitize/angular-sanitize',
            'angular-touch': '../../bower_components/angular-touch/angular-touch',
            'angular-ui-grid': '../../bower_components/angular-ui-grid/ui-grid',
            jquery: '../../bower_components/jquery/dist/jquery',
            'what-input': '../../bower_components/what-input/what-input',
            'motion-ui': '../../bower_components/motion-ui/dist/motion-ui',
            'foundation': '../../bower_components/foundation-sites/js/foundation.core',
            'foundation-util-mediaQuery': '../../bower_components/foundation-sites/js/foundation.util.mediaQuery',
            'foundation-util-keyboard': '../../bower_components/foundation-sites/js/foundation.util.keyboard',
            'foundation-util-box': '../../bower_components/foundation-sites/js/foundation.util.box',
            'foundation-util-nest': '../../bower_components/foundation-sites/js/foundation.util.nest',
            'foundation-dropdown': '../../bower_components/foundation-sites/js/foundation.dropdown',
            /* TODO
             'bower_components/foundation-sites/js/foundation.util.*.js',
             // Paths to individual JS components defined below
             'bower_components/foundation-sites/js/foundation.abide.js',
             'bower_components/foundation-sites/js/foundation.accordion.js',
             'bower_components/foundation-sites/js/foundation.accordionMenu.js',
             'bower_components/foundation-sites/js/foundation.drilldown.js',
             
             'bower_components/foundation-sites/js/foundation.dropdownMenu.js',
             'bower_components/foundation-sites/js/foundation.equalizer.js',
             'bower_components/foundation-sites/js/foundation.interchange.js',
             'bower_components/foundation-sites/js/foundation.magellan.js',
             'bower_components/foundation-sites/js/foundation.offcanvas.js',
             'bower_components/foundation-sites/js/foundation.orbit.js',
             'bower_components/foundation-sites/js/foundation.responsiveMenu.js',
             'bower_components/foundation-sites/js/foundation.responsiveToggle.js',
             'bower_components/foundation-sites/js/foundation.reveal.js',
             'bower_components/foundation-sites/js/foundation.slider.js',
             'bower_components/foundation-sites/js/foundation.sticky.js',
             'bower_components/foundation-sites/js/foundation.tabs.js',
             'bower_components/foundation-sites/js/foundation.toggler.js',
             'bower_components/foundation-sites/js/foundation.tooltip.js',
             */

            bootstrap: 'bootstrap'
        },
        deps: [
            'bootstrap'
        ]
    });
}(require));


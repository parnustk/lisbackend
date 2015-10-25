/**
 * front end Development set up
 * @param {type} param
 */
requirejs.config({
    baseUrl: (typeof BaseUrl !== 'undefined') ? BaseUrl : './js/',
    paths: {
        "modernizr": 'lib/modernizr/modernizr',
        "jquery": 'lib/jquery/dist/jquery.min',
        "jquery.cookie": 'lib/jquery.cookie/jquery.cookie',
        "foundation": 'lib/foundation/js/foundation',
        "foundation.abide": 'lib/foundation/js/foundation/foundation.abide',
        "foundation.accordion": 'lib/foundation/js/foundation/foundation.accordion',
        "foundation.alert": 'lib/foundation/js/foundation/foundation.alert',
        "foundation.clearing": 'lib/foundation/js/foundation/foundation.clearing',
        "foundation.dropdown": 'lib/foundation/js/foundation/foundation.dropdown',
        "foundation.equalizer": 'lib/foundation/js/foundation/foundation.equalizer',
        "foundation.interchange": 'lib/foundation/js/foundation/foundation.interchange',
        "foundation.joyride": 'lib/foundation/js/foundation/foundation.joyride',
        "foundation.magellan": 'lib/foundation/js/foundation/foundation.magellan',
        "foundation.offcanvas": 'lib/foundation/js/foundation/foundation.offcanvas',
        "foundation.orbit": 'lib/foundation/js/foundation/foundation.orbit',
        "foundation.reveal": 'lib/foundation/js/foundation/foundation.reveal',
        "foundation.slider": 'lib/foundation/js/foundation/foundation.slider',
        "foundation.tab": 'lib/foundation/js/foundation/foundation.tab',
        "foundation.toolbar": 'lib/foundation/js/foundation/foundation.toolbar',
        "foundation.topbar": 'lib/foundation/js/foundation/foundation.topbar',
        "imagesloaded": 'lib/imagesloaded/imagesloaded.pkgd',
        "angular": 'lib/angular/angular',
        "angularRoute": 'lib/angular-route/angular-route',
        "angularCookies": 'lib/angular-cookies/angular-cookies'
    },
    shim: {
        "angular": {
            exports: 'angular'
        },
        "angularRoute": {
            deps: ['angular'],
            exports: 'angular'
        },
        "angularCookies": {
            deps: ['angular'],
            exports: 'angular'
        },
        "jquery": ['modernizr'],
        "jquery.cookie": ['jquery'],
        "foundation": ['jquery'],
        "foundation.abide": ['foundation'],
        "foundation.accordion": ['foundation'],
        "foundation.alert": ['foundation'],
        "foundation.clearing": ['foundation'],
        "foundation.dropdown": ['foundation'],
        "foundation.equalizer": ['foundation'],
        "foundation.interchange": ['foundation'],
        "foundation.joyride": ['foundation', 'jquery.cookie'],
        "foundation.magellan": ['foundation'],
        "foundation.offcanvas": ['foundation'],
        "foundation.orbit": ['foundation'],
        "foundation.reveal": ['foundation'],
        "foundation.slider": ['foundation'],
        "foundation.tab": ['foundation'],
        "foundation.toolbar": ['foundation'],
        "foundation.topbar": ['foundation']
    },
    deps: ['foundation', 'app']
});
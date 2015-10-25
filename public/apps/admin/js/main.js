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
        "moment": 'lib/moment/moment-with-locales',
        "angular": 'lib/angular/angular',
        "angular-route": 'lib/angular-route/angular-route',
        "angular-cookies": 'lib/angular-cookies/angular-cookies',
        "angular-resource": 'lib/angular-resource/angular-resource',
        "angular-touch": 'lib/angular-touch/angular-touch',
        "angular-ui-grid": 'lib/angular-ui-grid/ui-grid',
        "adminModule": 'module/admin/adminModule',
        "app": 'app'
    },
    shim: {
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
        "foundation.topbar": ['foundation'],
        "angular": ['foundation'],
        "angular-route": ['angular'],
        "angular-resource": ['angular'],
        "angular-touch": ['angular'],
        "angular-ui-grid": ['angular-touch'],
        'app': {
            deps: ['angular-route', 'angular-resource', 'angular-ui-grid']
        }
    },
    deps: ['app']
});

"use strict";

define([
    'jquery',
    'foundation',
    'foundation.reveal'
], function ($) {

    $(document).ready(function () { //DOM loaded
        $(document).foundation(); //start foundation
        require(['adminModule'], function () {//start angular modules
            require(['module/models'], function () {//start angular models
                require(['module/controllers'], function () { //start angular controllers
                    angular.bootstrap(document, ['adminModule']);
                });
            });
        });
    });
});


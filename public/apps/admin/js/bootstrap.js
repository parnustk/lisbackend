(function (document) {
    "use strict";

    define([
        'jquery',
        'foundation',
        'foundation.reveal',
        'angular'
    ], function ($) {

        $(document).ready(function () { //DOM loaded
            
            $(document).foundation(); //start foundation

            require(['adminModule'], function () {//start angular modules
                console.log(1);
                require(['module/models'], function () {//start angular models
                    console.log(2);
                    require(['module/controllers'], function () { //start angular controllers
                        console.log(2);
                        angular.bootstrap(document, ['adminModule']);
                    });
                });
            });
        });

        return undefined;
    });

}(document));
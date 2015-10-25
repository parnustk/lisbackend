require([
    'jquery',
    'foundation',
    'foundation.reveal',
    'imagesloaded'
], function ($) {
    $(function () {//document ready
        $(this).foundation(); //start foundation
        require(['adminModule'], function () {
            /*start adminModule*/
        });
    });
});


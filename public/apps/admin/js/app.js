require([
    'jquery',
    'foundation',
    'foundation.reveal',
    'imagesloaded'
], function (jQuery) {
    jQuery(function () {//document ready
        jQuery(this).foundation(); //start foundation
        require(['adminModule'], function () {
            /*start adminModule*/
        });
    });
});


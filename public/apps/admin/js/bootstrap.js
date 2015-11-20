require([
    'jquery',
    'foundation',
    'foundation.reveal',
    'imagesloaded'
], function (jQuery) {

    jQuery(function () {//document ready
        jQuery(this).foundation(); //start foundation
        alert('here all good');
        require(['adminModule'], function () {
            /*start adminModule*/
            alert('here inner');
        });
    });
});


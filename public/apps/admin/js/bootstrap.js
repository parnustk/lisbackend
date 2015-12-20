/*global document, define, require */

define(
    [
        'jquery',
        'foundation',
        'foundation.reveal'
    ],
    /**
     * 
     * @param {type} $
     * @returns {undefined}
     */
    function ($) {

        "use strict";

        $(document).ready(function () { //DOM loaded
            $(document).foundation(); //start foundation
            require(['adminModule']);
        });

    }
);

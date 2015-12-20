
"use strict";

define([
    'jquery',
    'foundation',
    'foundation.reveal'

], function ($) {

    $(document).ready(function () { //DOM loaded
        $(document).foundation(); //start foundation
        require(['adminModule']);
    });
    
});


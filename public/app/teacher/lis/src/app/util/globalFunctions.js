/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

/**
 * Holds common functions used application wide
 * 
 * @param {type} window
 * @returns {Object}
 */
(function (window) {
    'use strict';

    define([
        'app/util/translations'
    ], function (translations) {

        return {
            /**
             * 
             * @param {String} k
             * @returns {String}
             */
            T: function(k) {
                if(!!translations[window.LisGlobals.L][k]) {
                    return translations[window.LisGlobals.L][k];
                }
                return k;
            },
            /**
             * Leaves only id property for sub level objects
             * required by Doctrine to work
             * Needed for models which have associotions
             * 
             * @param {type} data
             * @returns {Array}
             */
            cleanData: function (data) {
                var level = 0;
                function copy(o) {
                    var _out, v, _key;
                    _out = Array.isArray(o) ? [] : {};
                    for (_key in o) {
                        v = o[_key];
                        if (typeof v === "object" && v !== null) {
                            if(level < 1 && !Array.isArray(o)) {
                                level++;
                                _out[_key] = copy(v);
                                level--;
                            } else if (level < 2 && Array.isArray(o)) {
                                level++;
                                _out[_key] = copy(v);
                                level--;
                            }
                        } else {
                            if (!level) {
                                _out[_key] = v;
                            } else {
                                if (_key === 'id') {
                                    _out[_key] = v;
                                }
                            }
                        }
                    }
                    return _out;
                }
                return copy(data);
            },
            /**
             * 
             * @param {type} result
             * @returns {Boolean}
             */
            resultHandler: function (result) {
                var s = true;
                if (!result.success) {
                    console.log(result.message);
                    this.alertErrorMsg(result.message);
                    
                    s = false;
                }
                return s;
            },
            /**
             * 
             * @param {string} alertMessage
             * @returns {string} modal window with custom text as input
             */
            alertErrorMsg: function (alertMessage) {
                $("#errorModal .modal-title").text(this.T('LIS_ERROR'));
                $("#errorModal .modal-body").text(alertMessage);
                $("#errorModal").modal('show');
            },
            
            /**
             *
             * @param alertmessage
             * @returns {string} modal window with custom text as input
             */
            alertSuccessMsg: function (alertmessage) {
                $("#successModal .modal-title").text(this.T('LIS_SUCCESS'));
                $("#successModal .modal-body").text(alertMessage);
                $("#successModal").modal('show');
            }
        };
    });

}(window));

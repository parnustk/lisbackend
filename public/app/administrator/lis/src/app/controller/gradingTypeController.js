/** 
 * 
 * Licence of Learning Info System (LIS)
 * 
 * @link       https://github.com/parnustk/lisbackend
 * @copyright  Copyright (c) 2015-2016 Sander Mets, Eleri Apsolon, Arnold Tšerepov, Marten Kähr, Kristen Sepp, Alar Aasa, Juhan Kõks
 * @license    You may use LIS for free, but you MAY NOT sell it without permission.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
 * 
 */

/* global define */

(function (define) {
    'use strict';

    define([], function () {

        function gradingTypeController($scope, $routeParams, gradingTypeModel) {

            $scope.gradingType={
                gradingType: ''
            };
            
            $scope.Create = function(){
                gradingTypeModel
                        .Create($scope.gradingType)
                        .then(
                            function(result.success){
                                alert('Good');
                            }else{
                                alert('BAD');
                            }
                        );
            };
            gradingTypeModel.GetList().then(
                    function (result) {
                        $scope.gradingType = result.data;
                    }
            );
        }

        gradingTypeController.$inject = ['$scope', '$routeParams', 'gradingTypeModel'];

        return gradingTypeController;
    });

}(define));



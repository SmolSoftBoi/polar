/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/*global angular */
angular.module('polar').run(['$rootScope', function ($rootScope) {
    'use strict';

    $rootScope.config = {
        baseUrl: '',
        indexPage: 'index.php'
    };

    $rootScope.polar = {
        brandColor: '0275d8'
    };
}]);
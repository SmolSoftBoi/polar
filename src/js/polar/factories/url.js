/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * URL factory.
 */

/*global angular, location */
angular.module('polar').factory('url', ['$rootScope', '$location', function ($rootScope, $location) {
    'use strict';

    var siteUrl = function (uri) {
        var baseUrl = $rootScope.config.baseUrl;

        if (!baseUrl) {
            baseUrl = $location.protocol() + '://' + location.host;
        }

        return baseUrl + '/' + $rootScope.config.indexPage + '/' + uri;
    };

    return {
        siteUrl: siteUrl
    };
}]);
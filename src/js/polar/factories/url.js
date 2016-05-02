/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * URL factory.
 */

/*global angular, location */
angular.module('polar').factory('url', function ($location) {
    'use strict';

    return {
        baseUrl: function (uri) {
            var baseUrl = $location.protocol() + '://' + location.host;

            return baseUrl + '/' + uri;
        }
    };
});
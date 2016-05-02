/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Connection model factory.
 */

/*global angular */
angular.module('polar').factory('connectionModel', function ($http, url) {
    'use strict';

    var ttl = 30 * 1000;

    return {
        search: function (connectionParams) {
            return $http.post(url.baseUrl('api/connections/search'), connectionParams, {
                timeout: ttl
            });
        },
        getItems: function () {
            return $http.get(url.baseUrl('api/connections'), {
                timeout: ttl
            });
        },
        getItem: function (connectionId) {
            return $http.get(url.baseUrl('api/connections/' + connectionId), {
                timeout: ttl
            });
        },
        setItem: function (connectionItem) {
            return $http.post(url.baseUrl('api/connections'), connectionItem, {
                timeout: ttl
            });
        }
    };
});
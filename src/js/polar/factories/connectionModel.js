/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Connection model factory.
 */

/*global angular */
angular.module('polar').factory('connectionModel', function ($http, url) {
    'use strict';

    return {
        search: function (connectionParams) {
            return $http.post(url.baseUrl('api/connections/search'), connectionParams);
        },
        getItems: function () {
            return $http.get(url.baseUrl('api/connections'));
        },
        getItem: function (connectionId) {
            return $http.get(url.baseUrl('api/connections/' + connectionId));
        },
        setItem: function (connectionItem) {
            return $http.post(url.baseUrl('api/connections'), connectionItem);
        }
    };
});
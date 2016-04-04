/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * School model factory.
 */

/*global angular */
angular.module('polar').factory('schoolModel', function ($http, url) {
    'use strict';

    return {
        search: function (schoolParams) {
            return $http.post(url.baseUrl('api/schools/search'), schoolParams);
        },
        getItems: function () {
            return $http.get(url.baseUrl('api/schools'));
        },
        getItem: function (schoolId) {
            return $http.get(url.baseUrl('api/schools/' + schoolId));
        },
        setItem: function (schoolItem) {
            return $http.post(url.baseUrl('api/schools'), schoolItem);
        }
    };
});
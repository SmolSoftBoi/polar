/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * School model factory.
 */

/*global angular */
angular.module('polar').factory('schoolModel', ['$http', 'url', function ($http, url) {
    'use strict';

    return {
        search: function (schoolParams) {
            return $http.get(url.siteUrl('api/schools/search'), schoolParams);
        },
        getItems: function (schoolIds) {
            return $http.get(url.siteUrl('api/schools'), schoolIds);
        },
        getItem: function (schoolId) {
            return $http.get(url.siteUrl('api/schools'), schoolId);
        },
        setItems: function (schoolItems) {
            return $http.post(url.siteUrl('api/schools'), schoolItems);
        },
        setItem: function (schoolItem) {
            return $http.post(url.siteUrl('api/schools'), schoolItem);
        }
    };
}]);
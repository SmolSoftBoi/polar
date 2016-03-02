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
            $http.get(url.siteUrl('api/schools/search'), schoolParams).then(function successCallback(response) {
                return response.data;
            });
        },
        getItems: function (schoolIds) {
            $http.get(url.siteUrl('api/schools'), schoolIds).then(function successCallback(response) {
                return response.data;
            });
        },
        getItem: function (schoolId) {
            $http.get(url.siteUrl('api/schools/' + schoolId), schoolId).then(function successCallback(response) {
                return response.data;
            });
        },
        setItems: function (schoolItems) {
            $http.post(url.siteUrl('api/schools'), schoolItems).then(function successCallback(response) {
                return response.data;
            });
        },
        setItem: function (schoolItem) {
            $http.post(url.siteUrl('api/schools/' + schoolItem.schoolId), schoolItem)
                .then(function successCallback(response) {
                    return response.data;
                });
        }
    };
}]);
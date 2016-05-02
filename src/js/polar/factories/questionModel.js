/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Question model factory.
 */

/*global angular */
angular.module('polar').factory('questionModel', function ($http, url) {
    'use strict';

    return {
        search: function (questionParams) {
            return $http.post(url.baseUrl('api/questions/search'), questionParams);
        },
        getItems: function () {
            return $http.get(url.baseUrl('api/questions'), {
                cache: true
            });
        },
        getItem: function (questionId) {
            return $http.get(url.baseUrl('api/questions/' + questionId), {
                cache: true
            });
        },
        setItem: function (questionItem) {
            return $http.post(url.baseUrl('api/questions'), questionItem);
        },
        searchResponses: function (questionResponseParams) {
            return $http.post(url.baseUrl('api/questions/responses/search'), questionResponseParams);
        },
        getResponseItems: function () {
            return $http.get(url.baseUrl('api/questions/responses'), {
                cache: true
            });
        },
        getResponseItem: function (questionResponseId) {
            return $http.get(url.baseUrl('api/questions/responses/' + questionResponseId), {
                cache: true
            });
        },
        setResponseItem: function (questionResponseItem) {
            return $http.post(url.baseUrl('api/questions/responses'), questionResponseItem);
        }
    };
});
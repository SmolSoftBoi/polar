/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz model factory.
 */

/*global angular */
angular.module('polar').factory('quizModel', ['$http', 'url', function ($http, url) {
    'use strict';

    return {
        search: function (quizParams) {
            return $http.post(url.siteUrl('api/quizzes/search'), quizParams);
        },
        getItems: function (quizIds) {
            return $http.get(url.siteUrl('api/quizzes'), quizIds);
        },
        getItem: function (quizId) {
            return $http.get(url.siteUrl('api/quizzes'), quizId);
        },
        setItems: function (quizItems) {
            return $http.post(url.siteUrl('api/quizzes'), quizItems);
        },
        setItem: function (quizItem) {
            return $http.post(url.siteUrl('api/quizzes'), quizItem);
        }
    };
}]);
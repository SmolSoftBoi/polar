/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz model factory.
 */

/*global angular */
angular.module('polar').factory('quizModel', function ($http, url) {
    'use strict';

    return {
        search: function (quizParams) {
            return $http.post(url.baseUrl('api/quizzes/search'), quizParams);
        },
        getItems: function () {
            return $http.get(url.baseUrl('api/quizzes'), {
                cache: true
            });
        },
        getItem: function (quizId) {
            return $http.get(url.baseUrl('api/quizzes/' + quizId), {
                cache: true
            });
        },
        setItem: function (quizItem) {
            return $http.post(url.baseUrl('api/quizzes'), quizItem);
        },
        getItemBySlug: function (quizSlug) {
            return $http.get(url.baseUrl('api/quizzes/' + quizSlug), {
                cache: true
            });
        }
    };
});
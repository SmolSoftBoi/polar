/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Welcome controller.
 */

/*global angular */
angular.module('polar')
    .controller('welcome', function ($rootScope, $scope, quizParams, quizModel) {
        'use strict';

        function load() {
            $scope.go = go;

            $rootScope.session.then(function (session) {
                angular.forEach(session.user.schools, function (school) {
                    quizParams.schoolIds.push(school.schoolId);
                });

                loadQuizzes();
            });
        }

        function loadQuizzes() {
            var search = angular.copy(quizParams);

            search.schoolIds = [];

            quizModel.search(search).then(function successCallback(response) {
                var quizzes = angular.fromJson(response.data);

                $scope.quizzes = quizzes;
            });
        }

        var go = function () {
            location.pathname = 'quizzes/' + $scope.quiz.quizSlug;
        };

        load();
    });
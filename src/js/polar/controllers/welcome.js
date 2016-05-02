/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Welcome controller.
 */

/*global angular */
angular.module('polar')
    .controller('welcome', function ($rootScope, $scope, $filter, quizParams, quizModel) {
        'use strict';

        function load() {
            $scope.go = go;

            $rootScope.session.then(function () {
                loadQuizzes();
            });
        }

        function loadQuizzes() {
            var search = angular.copy(quizParams);

            search.schoolIds = [];

            $rootScope.session.then(function () {
                var roles = Object.keys($rootScope.user.roles).map(function (roleId) {
                    return $rootScope.user.roles[roleId];
                });

                if ($filter('filter')(roles, {roleKey: 'teacher'}, true).length === 1) {
                    search.userId = $rootScope.user.userId;
                } else {
                    search.minLaunchTimestamp = new Date(Date.now());
                }

                angular.forEach($rootScope.user.schools, function (school) {
                    search.schoolIds.push(school.schoolId);
                });

                quizModel.search(search).then(function successCallback(response) {
                    var quizzes = angular.fromJson(response.data);

                    $scope.quizzes = quizzes;
                });
            });
        }

        var go = function () {
            location.pathname = 'quizzes/' + $scope.quiz.quizSlug;
        };

        load();
    });
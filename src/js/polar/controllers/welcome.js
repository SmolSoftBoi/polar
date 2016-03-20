/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Welcome controller.
 */

/*global angular */
angular.module('polar')
    .controller('welcome', ['$scope', 'quizParams', 'quizModel', function ($scope, quizParams, quizModel) {
        'use strict';

        $scope.quizzes = {};

        var quizParams = angular.copy(quizParams);

        quizParams.schoolIds = true;

        quizModel.search(quizParams).then(function successCallback(response) {
            angular.forEach(response.data, function (quiz) {
                $scope.quizzes[quiz.quizId] = quiz;
            });
        });
    }]);
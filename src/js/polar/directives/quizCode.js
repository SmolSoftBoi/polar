/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz code directive.
 */

/*global angular */
angular.module('polar').directive('ngQuizCode', function ($q, quizModel, quizParams) {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, controller) {
            controller.$asyncValidators.integer = function (modelValue) {
                if (controller.$isEmpty(modelValue)) {
                    return $q.when();
                }

                var search = angular.copy(quizParams);

                search.code = modelValue

                return quizModel.search(search).then(function successCallback(response) {
                    var quizzes = angular.fromJson(response.data);

                    if (Object.keys(quizzes).length === 1) {
                        scope.quiz = quizzes[Object.keys(quizzes)[0]];

                        return $q.resolve(quizzes[Object.keys(quizzes)[0]]);
                    }

                    return $q.reject();
                });
            };
        }
    };
});
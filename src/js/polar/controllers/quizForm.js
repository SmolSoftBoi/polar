/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz controller.
 */

/*global angular */
angular.module('polar')
    .controller('quizForm', function ($rootScope, $scope, quizModel, answerItem, questionItem, quizItem) {
        'use strict';

        function load() {
            $scope.quiz = angular.copy(quizItem);

            addQuestion();

            $rootScope.session.then(function () {
                $scope.quiz.userId = $rootScope.user.userId;
            });

            $scope.addQuestion    = addQuestion;
            $scope.removeQuestion = removeQuestion;
            $scope.addAnswer      = addAnswer;
            $scope.removeAnswer   = removeAnswer;
            $scope.setQuiz        = setQuiz;
        }

        var addQuestion = function () {
            var question = angular.copy(questionItem);

            addAnswer(question);
            addAnswer(question);

            $scope.quiz.questions.push(question);
        };

        var removeQuestion = function (questionId) {
            $scope.quiz.questions.splice(questionId, 1);
        };

        var addAnswer = function (question) {
            var answer = angular.copy(answerItem);

            question.answers.push(answer);
        };

        var removeAnswer = function (question, answerId) {
            question.answers.splice(answerId, 1);
        };

        var setQuiz = function () {
            quizModel.setItem($scope.quiz).then(function successCallback(response) {

            });
        };

        load();
    });
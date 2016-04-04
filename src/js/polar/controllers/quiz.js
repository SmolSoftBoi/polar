/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz controller.
 */

/*global angular, location */
angular.module('polar')
    .controller('quiz', function ($rootScope, $scope, connectionModel, questionModel, quizModel, connectionItem, connectionParams, questionResponseItem, quizItem) {
        'use strict';

        function load() {
            $scope.questionId     = 0;
            $scope.score          = 0;
            $scope.start          = start;
            $scope.nextQuestionId = nextQuestionId;
            $scope.nextQuestion   = nextQuestion;
            $scope.answerQuestion = answerQuestion;

            loadQuiz();
        }

        function loadQuiz() {
            var slug = location.pathname.split('/');
            slug     = slug[slug.length - 1];

            $rootScope.session.then(function () {
                quizModel.getItemBySlug(slug).then(function successCallback(response) {
                    var quiz = angular.fromJson(response.data);

                    if (quiz.userId === $rootScope.user.userId) {
                        checkConnections(quiz.quizId);
                    } else {
                        connect(quiz.quizId);
                    }

                    angular.forEach(quiz.questions, function (question, questionId) {
                        quiz.questions[questionId].answersCount = Object.keys(question.answers).length;
                    });

                    $scope.quiz = quiz;
                });
            });
        }

        function connect(quizId) {
            var connection = angular.copy(connectionItem);

            connection.quiz = angular.copy(quizItem);

            connection.userId = $rootScope.user.userId;
            connection.connectionTimestamp = new Date();
            connection.quiz.quizId = quizId;

            connectionModel.setItem(connection);
        };

        function checkConnections(quizId) {
            var search = angular.copy(connectionParams);

            search.quizId = quizId;

            connectionModel.search(search).then(function successCallback(response) {
                var connections = angular.fromJson(response.data);

                $scope.connections = connections;
            });
        };

        var start = function () {
            $scope.questionId = nextQuestionId(0);
        };

        var nextQuestionId = function (questionId) {
            if (questionId === undefined) {
                questionId = 0;
            }

            var questionIds = Object.keys($scope.quiz.questions);

            if (questionId === 0) {
                return parseInt(questionIds[0]);
            }

            var index = questionIds.indexOf(questionId.toString());

            if (index === questionIds.length - 1) {
                return -1;
            }

            return parseInt(questionIds[index + 1]);
        };

        var nextQuestion = function (questionId) {
            $scope.questionId = nextQuestionId(questionId);
        };

        var answerQuestion = function ($event, answer) {
            var questionResponse = angular.copy(questionResponseItem);

            questionResponse.answerId = answer.answerId;
            questionResponse.userId   = $rootScope.user.userId;

            questionModel.setResponseItem(questionResponse).then(function successCallback(response) {
                var questionResponse = angular.fromJson(response.data);

                var questionId = questionResponse.answer.questionId;

                angular.element($event.target).addClass('active');

                $scope.quiz.questions[questionId].answered = true;

                angular.forEach($scope.quiz.questions[questionId].answers, function (answer) {
                    var correct = false;

                    if (answer.answerId === questionResponse.correctAnswerId) {
                        correct = true;
                    }

                    $scope.quiz.questions[questionId].answers[answer.answerId].correct = correct;
                });

                if (questionResponse.score === 0) {
                    quiz.questions[questionId].answers[questionResponse.answerId].correct = false;
                }

                $scope.score += questionResponse.score;
            });
        };

        load();
    });
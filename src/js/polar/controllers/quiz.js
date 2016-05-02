/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz controller.
 */

/*global angular, document, location */
angular.module('polar')
    .controller('quiz', function ($rootScope, $scope, $filter, $interval, $timeout, connectionModel, questionModel, quizModel, connectionItem, connectionParams, questionResponseItem, questionResponseParams, quizItem) {
        'use strict';

        function load() {
            $scope.questionId        = 0;
            $scope.score             = 0;
            $scope.start             = start;
            $scope.nextQuestionId    = nextQuestionId;
            $scope.nextQuestion      = nextQuestion;
            $scope.answerQuestion    = answerQuestion;
            $scope.showCorrectAnswer = showCorrectAnswer;

            loadQuiz();
        }

        function loadQuiz() {
            var slug = location.pathname.split('/');
            slug     = slug[slug.length - 1];

            $rootScope.session.then(function () {
                quizModel.getItemBySlug(slug).then(function successCallback(response) {
                    var quiz = angular.fromJson(response.data);

                    if (quiz.userId === $rootScope.user.userId) {
                        $scope.role = 'teacher';
                    } else {
                        $scope.role = 'student';
                    }

                    if (quiz.live === true) {
                        switch ($scope.role) {
                            case 'teacher':
                                checkConnections(quiz.quizId);
                                break;
                            case 'student':
                                connect(quiz.quizId);
                                break;
                        }
                    }

                    angular.forEach(quiz.questions, function (question, questionId) {
                        quiz.questions[questionId].answersCount = Object.keys(question.answers).length;

                        quiz.questions[questionId].categories = [];
                        quiz.questions[questionId].series     = [{
                            data: [],
                            dataLabels: {
                                enabled: true
                            }
                        }];

                        angular.forEach(question.answers, function (answer) {
                            quiz.questions[questionId].categories.push(answer.answer);
                            quiz.questions[questionId].series[0].data.push(0);
                        });
                    });

                    $scope.quiz = quiz;

                    var quizIds = Object.keys(quiz.questions);

                    $scope.lastQuestionId = parseInt(quizIds[quizIds.length - 1]);
                });
            });
        }

        function connect(quizId) {
            var connection = angular.copy(connectionItem), polling = false;

            connection.quiz = angular.copy(quizItem);

            connection.userId      = $rootScope.user.userId;
            connection.quiz.quizId = quizId;

            var setItem = function () {
                connectionModel.setItem(connection).then(function successCallback(response) {
                    var connection = angular.fromJson(response.data);

                    processConnection(connection);

                    if (polling === false) {
                        pollConnection();

                        polling = true;
                    }
                });
            };

            setItem();

            $interval(function () {
                setItem();
            }, 15 * 1000);
        };

        function checkConnections(quizId) {
            var search = angular.copy(connectionParams);

            search.quizId = quizId;

            connectionModel.search(search).then(function successCallback(response) {
                var connections = angular.fromJson(response.data);

                $scope.connections = connections;

                $timeout(function () {
                    checkConnections(quizId);
                }, 1000);
            }, function errorCallback() {
                $timeout(function () {
                    checkConnections(quizId);
                }, 1000 * 1.2);
            });
        };

        function pollConnection() {
            connectionModel.getItem($scope.connection.connectionId).then(function successCallback(response) {
                var connection = angular.fromJson(response.data);

                processConnection(connection);

                $timeout(function () {
                    pollConnection();
                }, 1000);
            }, function errorCallback() {
                $timeout(function () {
                    pollConnection();
                }, 1000 * 1.2);
            });
        };

        function processConnection(connection) {
            if (angular.equals($scope.connection, connection)) {
                return;
            }

            $scope.connection = connection;

            $scope.questionId = connection.quiz.questionId;
        };

        function checkQuestionResponses() {
            var search = angular.copy(questionResponseParams);

            search.questionId = $scope.quiz.questionId;

            questionModel.searchResponses(search).then(function successCallback(response) {
                var questionResponses = angular.fromJson(response.data);

                $scope.quiz.questions[$scope.questionId.toString()].responses = questionResponses;

                angular.forEach($scope.quiz.questions[$scope.questionId.toString()].answers, function (answer, answerId) {
                    var mappedQuestionResponses = Object.keys(questionResponses).map(function (questionResponseId) {
                        return questionResponses[questionResponseId];
                    });

                    $scope.quiz.questions[$scope.questionId.toString()].answers[answerId].responses = $filter('filter')(mappedQuestionResponses, {answerId: answer.answerId});
                });

                var data = [];

                angular.forEach($scope.quiz.questions[$scope.questionId.toString()].answers, function (answer) {
                    data.push(answer.responses.length);
                });

                $scope.quiz.questions[$scope.questionId.toString()].series[0].data = data;

                console.log($scope.quiz.series);

                $timeout(function () {
                    checkQuestionResponses();
                }, 1000 * 1.2);
            }, function errorCallback(response) {
                $timeout(function () {
                    checkQuestionResponses();
                }, 1000 * 1.2);
            });
        };

        var start = function () {
            $scope.questionId = nextQuestionId(0);

            checkQuestionResponses();
        };

        var nextQuestionId = function (questionId) {
            if (questionId === undefined) {
                questionId = 0;
            }

            var questionIds = Object.keys($scope.quiz.questions), index = questionIds.indexOf(questionId.toString());

            if (questionId === 0) {
                index = -1;
            }

            if (index === questionIds.length - 1) {
                questionId = -1;
            } else {
                questionId = parseInt(questionIds[index + 1]);
            }

            $scope.quiz.questionId = questionId;

            if ($scope.quiz.userId === $rootScope.user.userId) {
                var quiz = angular.copy($scope.quiz);

                quiz.questions = [];

                quizModel.setItem(quiz);
            }

            return questionId;
        };

        var nextQuestion = function (questionId) {
            $scope.questionId = nextQuestionId(questionId);
        };

        var showCorrectAnswer = function (question) {
            var colors = [];

            angular.forEach(question.answers, function (answer) {
                if (answer.score === 0) {
                    colors.push($rootScope.style.brandDanger);
                } else {
                    colors.push($rootScope.style.brandSuccess);
                }
            });

            $scope.quiz.questions[question.questionId.toString()].series[0].colorByPoint = true;
            $scope.quiz.questions[question.questionId.toString()].series[0].colors       = colors;
        };

        var answerQuestion = function ($event, answer) {
            if ($scope.quiz.questions[$scope.questionId.toString()].answered) {
                return;
            }

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
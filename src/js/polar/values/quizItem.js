/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz item.
 */

/*global angular */
angular.module('polar').value('quizItem', {
    quizId: undefined,
    questionId: undefined,
    userId: undefined,
    quizName: undefined,
    quizSlug: undefined,
    description: undefined,
    code: undefined,
    launchTimestamp: undefined,
    live: undefined,
    score: undefined,
    questions: []
});
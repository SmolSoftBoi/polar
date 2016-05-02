/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Question item.
 */

/*global angular */
angular.module('polar').value('questionItem', {
    questionId: undefined,
    questionTypeId: undefined,
    quizId: undefined,
    question: undefined,
    timeLimit: undefined,
    responses: [],
    answers: []
});
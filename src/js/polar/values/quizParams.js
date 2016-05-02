/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Quiz parameters.
 */

/*global angular */
angular.module('polar').value('quizParams', {
    code: undefined,
    connectionId: undefined,
    quizSlug: undefined,
    schoolIds: [],
    userId: undefined,
    minLaunchTimestamp: undefined
});
/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Authentication controller.
 */

/*global angular */
angular.module('polar').controller('auth', ['$scope', 'emailItem', 'userItem', function ($scope, emailItem, userItem) {
    'use strict';

    $scope.user = angular.copy(userItem);
    $scope.user.emails.push(angular.copy(emailItem));
}]);
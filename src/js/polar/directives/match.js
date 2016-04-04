/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Match directive.
 */

/*global angular */
angular.module('polar').directive('ngMatch', function () {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, controller) {
            controller.$parsers.unshift(function (value) {
                var valid = scope.$eval(attrs.ngMatch).$viewValue === value;

                controller.$setValidity('match', valid);

                if (valid) {
                    return valid;
                }

                return false;
            });

            scope.$watch(attrs.ngMatch, function () {
                controller.$setViewValue(controller.$viewValue);
            });
        }
    };
});
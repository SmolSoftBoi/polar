/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * March directive.
 */

/*global angular */
angular.module('polar').directive('ngMatch', [function () {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, ctrl) {
            ctrl.$parsers.unshift(function (value) {
                var valid = scope.$eval(attrs.ngMatch).$viewValue === value;

                ctrl.$setValidity('match', valid);

                if (valid) {
                    return valid;
                }

                return false;
            });

            scope.$watch(attrs.ngMatch, function () {
                ctrl.$setViewValue(ctrl.$viewValue);
            });
        }
    };
}]);
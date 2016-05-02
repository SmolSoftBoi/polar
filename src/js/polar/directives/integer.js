/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Integer directive.
 */

/*global angular */
angular.module('polar').directive('ngInteger', function () {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, controller) {
            var INT_REGEXP = /^\-?\d+$/;

            controller.$validators.integer = function (modelValue, viewValue) {
                if (controller.$isEmpty(modelValue)) {
                    return true;
                }

                if (INT_REGEXP.test(viewValue)) {
                    return true;
                }

                return false;
            };
        }
    };
});
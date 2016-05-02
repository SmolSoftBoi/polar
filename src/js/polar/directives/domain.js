/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Domain directive.
 */

/*global angular */
angular.module('polar').directive('ngDomain', function () {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, controller) {
            var DOMAIN_REGEXP = /^[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i;

            var value = controller.$viewValue;

            var valid;

            if (value) {
                valid = DOMAIN_REGEXP.test(value);
            }

            controller.$setValidity('domain', valid);

            if (valid) {
                return valid;
            }

            return false;
        }
    };
});
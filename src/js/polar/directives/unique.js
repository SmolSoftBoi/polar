/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Unique directive.
 */

/*global angular */
angular.module('polar').directive('ngUnique', function ($http, $q, url) {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, controller) {
            var cancel = $q.defer();

            scope.$watch(function () {
                return controller.$viewValue;
            }, function () {
                cancel.resolve();
                cancel = $q.defer();

                $http.get(url.baseUrl('api/form/unique'), {
                    params: {
                        control: attrs.ngUnique,
                        value: controller.$viewValue
                    },
                    timeout: cancel.promise
                }).then(function successCallback(response) {
                    controller.$setValidity('unique', response.data.unique);
                }, function errorCallback() {
                    controller.$setValidity('unique', null);
                });
            });
        }
    };
});
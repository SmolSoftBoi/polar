/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Unique directive.
 */

/*global angular */
angular.module('polar').directive('ngUnique', ['$http', '$q', 'url', function ($http, $q, url) {
    'use strict';

    return {
        require: '^ngModel',
        restrict: 'A',
        link: function (scope, element, attrs, ctrl) {
            var cancel = $q.defer();

            scope.$watch(function () {
                return ctrl.$viewValue;
            }, function () {
                cancel.resolve();
                cancel = $q.defer();

                $http.get(url.siteUrl('api/form/unique'), {
                    params: {
                        control: attrs.ngUnique,
                        value: ctrl.$viewValue
                    },
                    timeout: cancel.promise
                }).then(function successCallback(response) {
                    ctrl.$setValidity('unique', response.data.unique);
                }, function errorCallback(response) {
                    ctrl.$setValidity('unique', null);
                });
            });
        }
    };
}]);
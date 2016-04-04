/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/*global angular */
angular.module('polar').run(['$rootScope', '$http', '$q', 'url', function ($rootScope, $http, $q, url) {
    'use strict';

    function load() {
        var q = $q.defer();

        $http.get(url.baseUrl('api/userdata')).then(function successCallback(response) {
            var session = angular.fromJson(response.data);

            $rootScope.polar = session.polar;

            if (session.user) {
                $rootScope.user = session.user;
            }

            q.resolve(session);
        });

        $rootScope.session = q.promise;
    }

    load();
}]);
/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/*global angular, Highcharts */
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

        $rootScope.style = {
            grayLightest: '#f7f7f9',
            brandPrimary: '#0275d8',
            brandSuccess: '#5cb85c',
            brandDanger: '#d9534f',
            fontSizeLg: '1.25rem',
        };

        Highcharts.setOptions({
            chart: {
                backgroundColor: 'none',
                className: 'chart',
                spacingBottom: 0,
                spacingLeft: 0,
                spacingRight: 0,
                spacingTop: 0,
                style: undefined
            },
            colors: [$rootScope.style.brandPrimary],
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            loading: {
                hideDuration: 500,
                showDuration: 500
            },
            plotOptions: {
                column: {
                    borderColor: $rootScope.style.brandPrimary,
                    dataLabels: {
                        inside: true
                    }
                }
            },
            title: {
                text: null
            },
            xAxis: {
                labels: {
                    style: {
                        color: $rootScope.style.grayLightest,
                        fontSize: $rootScope.style.fontSizeLg
                    }
                }
            },
            yAxis: {
                title: {
                    text: null
                }
            }
        });
    }

    load();
}]);
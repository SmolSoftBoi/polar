/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Highcharts column directive.
 */

/*global angular, Highcharts */
angular.module('polar').directive('highchartsColumn', function ($parse) {
    'use strict';

    return {
        restrict: 'E',
        template: '<div></div>',
        link: function (scope, element, attrs) {
            attrs.chart = new Highcharts.chart(element[0], {
                chart: {
                    type: 'column'
                },
                title: {
                    text: attrs.title
                },
                tooltip: {
                    formatter: function () {
                        return this.x + ': ' + this.y;
                    }
                },
                yAxis: {
                    gridLineWidth: 0,
                    labels: {
                        enabled: false
                    }
                }
            });

            scope.$watch(function () {
                return attrs.categories;
            }, function () {
                if (attrs.chart.xAxis.length === 0) {
                    attrs.chart.addAxis($parse(attrs.categories)(scope));
                } else {
                    attrs.chart.xAxis[0].setCategories($parse(attrs.categories)(scope));
                }
            });

            scope.$watch(function () {
                return attrs.series;
            }, function () {
                var i;
                for (i = 0; i < $parse(attrs.series)(scope).length; i++) {
                    if (attrs.chart.series[i]) {
                        attrs.chart.series[0].setData($parse(attrs.series)(scope)[i].data);
                    } else {
                        attrs.chart.addSeries($parse(attrs.series)(scope)[i]);
                    }
                }

                if (i < attrs.chart.series.length - 1) {
                    var seriesLength = attrs.chart.series.length - 1;

                    for (j = seriesLength; j > i; j--) {
                        attrs.chart.series[j].remove();
                    }
                }
            });
        }
    };
});
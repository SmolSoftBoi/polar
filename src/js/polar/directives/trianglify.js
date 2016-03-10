/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Trianglify directive.
 */

/*global angular, Trianglify, XMLSerializer */
angular.module('polar').directive('trianglify', ['$parse', function ($parse) {
    'use strict';

    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                return attrs.trianglify;
            }, function () {
                var config = {
                    width: parseInt(element.css('width'), 10),
                    height: parseInt(element.css('height'), 10)
                };

                angular.extend(config, $parse(attrs.trianglify)(scope));

                var svg        = new Trianglify(config).svg();
                var serializer = new XMLSerializer();
                var svgString  = serializer.serializeToString(svg);
                var svgBase    = btoa(svgString);
                var svgData    = 'data:image/svg+xml;base64,' + svgBase;

                element.css({
                    'background-image': 'url(' + svgData + ')'
                });
            });
        }
    };
}]);
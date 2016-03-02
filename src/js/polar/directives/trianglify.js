/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Trianglify directive.
 */

/*global angular */
angular.module('polar').directive('trianglify', ['$parse', function ($parse) {
    'use strict';

    return {
        restrict: 'A',
        link: function (scope, element, attrs, ctrl) {
            scope.$watch(function () {
                return attrs.trianglify;
            }, function () {
                var config = {
                    width: parseInt(element.css('width')),
                    height: parseInt(element.css('height'))
                };

                angular.extend(config, $parse(attrs.trianglify)(scope));

                var svg        = Trianglify(config).svg();
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
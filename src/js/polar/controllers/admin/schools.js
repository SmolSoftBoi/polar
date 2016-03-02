/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Schools admin.
 */

/*global angular */
angular.module('polar')
    .controller('adminSchools', ['$scope',
        '$http',
        'schoolItem',
        'schoolModel',
        function ($scope, $http, schoolItem, schoolModel) {
            'use strict';

            $scope.school  = angular.copy(schoolItem);
            $scope.schools = schoolModel.search();

            $scope.modal = {
                title: undefined
            };

            $scope.add = function ($event) {
                $scope.school      = angular.copy(schoolItem);
                $scope.modal.title = $event.target.innerText;
            };

            $scope.save = function () {
                var schoolItem = schoolModel.setItem($scope.school);

                $scope.schools[schoolItem.schoolId] = schoolItem;

                angular.element(document.getElementById('schoolModal')).modal('hide');
            };
        }]);
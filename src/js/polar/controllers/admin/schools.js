/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Schools admin.
 */

/*global angular, document */
angular.module('polar')
    .controller('adminSchools', ['$scope', 'schoolItem', 'schoolModel', function ($scope, schoolItem, schoolModel) {
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
            var school = schoolModel.setItem($scope.school);

            $scope.schools[school.schoolId] = school;

            angular.element(document.getElementById('schoolModal')).modal('hide');
        };
    }]);
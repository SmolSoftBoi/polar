/*
 * Copyright © 2014 - 2016 Kristian Matthews. All rights reserved.
 */

/**
 * Schools admin.
 */

/*global angular, document */
angular.module('polar')
    .controller('adminSchools', function ($scope, schoolItem, schoolModel) {
        'use strict';

        $scope.school  = angular.copy(schoolItem);
        $scope.schools = {};

        $scope.modal = {
            title: undefined
        };

        schoolModel.search().then(function successCallback(response) {
            angular.forEach(response.data, function (school) {
                $scope.schools[school.schoolId] = school;
            });
        });

        $scope.add = function ($event) {
            $scope.school      = angular.copy(schoolItem);
            $scope.modal.title = $event.target.innerText;
        };

        $scope.save = function () {
            schoolModel.setItem($scope.school).then(function successCallback(response) {
                var school = response.data;

                $scope.schools[school.schoolId] = school;

                angular.element(document.getElementById('schoolModal')).modal('hide');
            });
        };
    });
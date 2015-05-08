'use strict';

var raspiSurveillanceServices = angular.module('raspiSurveillanceServices', ['ngResource']);

raspiSurveillanceServices.factory('Camera', ['$resource',
    function($resource) {
        return $resource('/api/cameras/:id');
    }]);

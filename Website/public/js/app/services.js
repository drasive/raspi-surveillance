'use strict';

angular.module('raspiSurveillance.services', ['ngResource']);


angular.module('raspiSurveillance.services').factory('Camera', ['$resource',
    function ($resource) {
      return $resource('/api/cameras/:id');
    }
]);

angular.module('raspiSurveillance.services').factory('Video', ['$resource',
    function ($resource) {
      return $resource('/api/videos/:filename');
    }
]);

'use strict';

angular.module('raspiSurveillance.services', ['ngResource']);


angular.module('raspiSurveillance.services').factory('Settings', ['$resource',
    function ($resource) {
      return $resource('api/settings');
    }
]);

angular.module('raspiSurveillance.services').factory('Camera', ['$resource',
    function ($resource) {
      return $resource('api/cameras/:id', { id: '@id' }, {
        update: {
          method: 'PUT'
        }
      });
    }
]);

angular.module('raspiSurveillance.services').factory('Video', ['$resource',
    function ($resource) {
      return $resource('api/videos/:filename');
    }
]);

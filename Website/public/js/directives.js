'use strict';

var raspiSurveillanceDirectives = angular.module('raspiSurveillanceDirectives', []);

// TODO: Fix finally
raspiSurveillanceDirectives.directive('clickAwait', function () {
  return {
    restrict: 'A',
    scope: {
      clickAwait: '&'
    },
    link: function (scope, element, attrs) {
      element.bind('click', function () {
        element.prop('disabled', true);

        scope.clickAwait().finally(function () {
          element.prop('disabled', false);
        });
      });
    }
  };
});

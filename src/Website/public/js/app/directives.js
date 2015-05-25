'use strict';

angular.module('raspiSurveillance.directives', []);


angular.module('raspiSurveillance.directives').directive('loader', function() {
  return {
    restrict: 'E',
    template: '<div class="loader-inner ball-clip-rotate-pulse">' +
              '    <div></div>' +
              '    <div></div>' +
              '</div>'
  }
});

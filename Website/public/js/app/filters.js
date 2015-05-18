'use strict';

angular.module('raspiSurveillance.filters', []);


angular.module('raspiSurveillance.filters').filter('orFilter', function () {
  return function (objects, properties, comparator) {
    if (!objects|| objects.length === 0) {
      return [];
    }
    if (!properties || properties.length === 0) {
      return [];
    }
    if (!comparator || comparator.trim() === '') {
      return objects;
    }

    var filteredObjects = [];

    objects.forEach(function(object) {
      var objectMatches = false;

      // Check if any object expression matches the comparator
      properties.forEach(function (property) {
        if (!objectMatches && object[property].toLowerCase().indexOf(comparator.toLowerCase()) > -1) {
          objectMatches = true;
        }
      });

      // Add the current object to the list of filtered objects
      if (objectMatches) {
        filteredObjects.push(object);
      }
    });

    return filteredObjects;
  };
});

angular.module('raspiSurveillance.filters').filter('secondsToDateTime', function () {
  return function (seconds) {
    return new Date(1970, 0, 1).setSeconds(seconds);
  };
});

/* Source: https://gist.github.com/yrezgui/5653591 */
angular.module('raspiSurveillance.filters').filter('filesize', function () {
  var units = [
    'bytes',
    'KB',
    'MB',
    'GB',
    'TB',
    'PB'
  ];

  return function (bytes, precision) {
    if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) {
      return '?';
    }

    var unit = 0;
    while (bytes >= 1000) {
      bytes /= 1000;
      unit++;
    }

    return bytes.toFixed(+precision) + ' ' + units[unit];
  };
});

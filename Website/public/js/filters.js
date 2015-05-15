'use strict';

var raspiSurveillanceFilters = angular.module('raspiSurveillanceFilters', []);

raspiSurveillanceApp.filter('secondsToDateTime', function () {
  return function (seconds) {
    return new Date(1970, 0, 1).setSeconds(seconds);
  };
});

/* Source: https://gist.github.com/yrezgui/5653591 */
raspiSurveillanceApp.filter('filesize', function () {
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

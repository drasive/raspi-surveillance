var raspiSurveillanceApp = angular.module('raspiSurveillanceApp', [
  'raspiSurveillanceControllers',
  'raspiSurveillanceServices',
  'xeditable'
]);

raspiSurveillanceApp.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});

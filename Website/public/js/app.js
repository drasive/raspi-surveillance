var raspiSurveillanceApp = angular.module('raspiSurveillanceApp', [
  'raspiSurveillanceServices',
  'raspiSurveillanceFilters',
  'raspiSurveillanceControllers',
  'raspiSurveillanceDirectives',

  'xeditable'
]);


// Set the xeditable theme and style
raspiSurveillanceApp.run(function (editableOptions, editableThemes) {
  // Set the theme to Bootstrap 3
  editableOptions.theme = 'bs3';

  // Use small input fields
  editableThemes.bs3.inputClass = 'input-sm';
});

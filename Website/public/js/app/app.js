'use strict';

angular.module('raspiSurveillance.app', [
  'raspiSurveillance.controllers',
  'raspiSurveillance.directives',
  'raspiSurveillance.filters',
  'raspiSurveillance.services',


  'xeditable'
]);


// Set the xeditable theme and style
angular.module('raspiSurveillance.app').run(function (editableOptions, editableThemes) {
  // Set the theme to Bootstrap 3
  editableOptions.theme = 'bs3';

  // Use small input fields
  editableThemes.bs3.inputClass = 'input-sm';
});

'use strict';

angular.module('raspiSurveillance.controllers').controller('CameraModeController', [
  '$scope',function ($scope) {

    // TODO: Implement

    var modes = ['Off', 'Streaming', 'Motion Detection'];

    // TODO: Start local livestream if in streaming mode
    //$scope.mode = ?.query(
    //  function (data) {
    //    console.log('Loaded operation mode: ' + modes[data.operation_mode]);
    //  },
    //  function (error) {
    //    console.error(error);
    //
    //    BootstrapDialog.show({
    //      title: 'Failed to load operation mode',
    //      message: 'An error occured while loading the operation mode.',
    //      type: BootstrapDialog.TYPE_DANGER,
    //      buttons: [
    //        {
    //          label: 'Close',
    //          cssClass: 'btn-primary',
    //          action: function (dialogItself) {
    //            dialogItself.close();
    //          }
    //        }
    //      ]
    //    });
    //  }
    //);
    $scope.isBusy = false;

    $scope.changeMode = function (mode) {
      $scope.isBusy = true;

      console.info('Changing to mode "' + modes[mode] + '"');
      $scope.mode = mode;

      $scope.isBusy = false;
    }

  }
]);

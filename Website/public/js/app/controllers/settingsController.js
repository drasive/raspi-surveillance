'use strict';

angular.module('raspiSurveillance.controllers').controller('SettingsController', [
  '$scope', '$rootScope', 'Settings', function ($scope, $rootScope, Settings) {

    // API
    $scope.getSettings = function(playStreamIfAvailable) {
      $scope.isLoading = true;

      return Settings.get(
        function (data) {
          console.log('Loaded settings');
          console.debug(data);

          $scope.isLoading = false;

          if (playStreamIfAvailable && data.camera.mode === 1) {
            $scope.playStream();
          }
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to load settings',
            message: 'Sorry, an error occured while loading the setings.<br />' +
                     'Please try again in a few moments.',
            type: BootstrapDialog.TYPE_DANGER,
            buttons: [{
              label: 'Close',
              cssClass: 'btn-primary',
              action: function (dialogItself) {
                dialogItself.close();
              }
            }]
          });
          $scope.isLoading = false;
        }
      );
    }

    $scope.saveSettings = function() {
      console.info('Saving settings');
      console.debug(JSON.stringify($scope.settings));

      $scope.isBusy = true;

      Settings.save($scope.settings,
        function (data) {
          $scope.isBusy = false;
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to save settings',
            message: 'Sorry, an error occured while saving the settings.<br />' +
                     'Please try again in a few moments.',
            type: BootstrapDialog.TYPE_DANGER,
            buttons: [{
              label: 'Close',
              cssClass: 'btn-primary',
              action: function (dialogItself) {
                dialogItself.close();
              }
            }]
          });
          $scope.isBusy = false;
        }
      );
    }

    // Attributes
    $scope.isLoading = false;
    $scope.settings = $scope.getSettings(true);

    $scope.isBusy = false;

    // Methods
    $scope.getCameraStreamURL = function () {
      return 'http://localhost:8554';
    }

    $scope.changeMode = function (mode) {
      var modes = ['Off', 'Streaming', 'Motion Detection'];
      console.info('Changing to mode "' + modes[mode] + '"');

      if (mode !== 1) {
        $rootScope.$broadcast('removingStreamSource', $scope.getCameraStreamURL());
      }

      $scope.settings.camera.mode = mode;
      $scope.saveSettings();
    }

    $scope.playStream = function() {
      $rootScope.$broadcast('playStream', $scope.getCameraStreamURL(), 'video/mp4');
    }

  }
]);

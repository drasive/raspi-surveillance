'use strict';

angular.module('raspiSurveillance.controllers').controller('SettingsController', [
  '$scope', '$rootScope', 'Settings', function ($scope, $rootScope, Settings) {

    // API
    $scope.getSettings = function (showModalOnError, playStreamIfAvailable) {
      $scope.isLoading = true;

      return Settings.get(
        function (response) {
          console.log('Loaded settings');
          console.debug(response);

          $scope.hasError = false;
          $scope.isLoading = false;

          if (playStreamIfAvailable && response.camera.mode === 1) {
            $scope.playStream();
          }
        },
        function (response) {
          console.error(response);

          if (showModalOnError) {
            BootstrapDialog.show({
              title: 'Failed to load settings',
              message: 'Sorry, an error occured while loading the setings.<br />' +
                'Please try again in a few moments.',
              type: BootstrapDialog.TYPE_DANGER,
              buttons: [
                {
                  label: 'Close',
                  cssClass: 'btn-primary',
                  action: function(dialog) {
                    dialog.close();
                  }
                }
              ]
            });
          }

          $scope.hasError = true;
          $scope.isLoading = false;
        }
      );
    }

    $scope.saveSettings = function() {
      console.info('Saving settings');
      console.debug(JSON.stringify($scope.settings));

      $scope.isBusy = true;

      Settings.save($scope.settings,
        function (response) {
          $scope.isBusy = false;
        },
        function (response) {
          console.error(response);

          BootstrapDialog.show({
            title: 'Failed to save settings',
            message: 'Sorry, an error occured while saving the settings.<br />' +
                     'Please try again in a few moments.',
            type: BootstrapDialog.TYPE_DANGER,
            buttons: [{
              label: 'Close',
              cssClass: 'btn-primary',
              action: function (dialog) {
                dialog.close();
              }
            }]
          });

          $scope.isBusy = false;
        }
      );
    }

    // Attributes
    $scope.isLoading = false;
    $scope.hasError = false;
    $scope.settings = $scope.getSettings(true, true);

    $scope.playingStreamUrl = null;
    $scope.isStreamPlaying = false;
    $scope.isBusy = false;

    // Methods
    $scope.getCameraStreamUrl = function () {
      return 'http://localhost:8554';
    }

    $scope.changeMode = function (mode) {
      var modes = ['Off', 'Streaming', 'Motion Detection'];
      console.info('Changing to mode "' + modes[mode] + '"');

      if (mode === 1 && $scope.playingStreamUrl && $scope.playingStreamUrl.toLowerCase() === $scope.getCameraStreamUrl().toLowerCase()) {
        // Current stream is local camera already
        $scope.isStreamPlaying = true;
      }
      else if (mode !== 1) {
        $scope.isStreamPlaying = false;
        $scope.playingStreamUrl = null;
        $rootScope.$broadcast('removingStreamSource', $scope.getCameraStreamUrl());
      }

      $scope.settings.camera.mode = mode;
      $scope.saveSettings();
    }

    $scope.playStream = function () {
      $scope.isStreamPlaying = true;
      $rootScope.$broadcast('playStream', $scope.getCameraStreamUrl(), 'video/mp4');
    }

    $scope.$on('playingStream', function (event, url, type) {
      $scope.playingStreamUrl = url;

      if ($scope.isStreamPlaying && url.toLowerCase() !== $scope.getCameraStreamUrl().toLowerCase()) {
        // New stream is not the local camera anymore
        console.info("Removing local camera highlight (stream from other source was opened)");
        $scope.isStreamPlaying = false;
      }
      else if ($scope.settings.camera.mode === 1 &&
        !$scope.isStreamPlaying && url.toLowerCase() === $scope.getCameraStreamUrl().toLowerCase()) {
        // New stream is freshly the local camera
        console.info("Highlighting local camera (stream from local camera was opened)");
        $scope.isStreamPlaying = true;
      }
    });

  }
]);

'use strict';

angular.module('raspiSurveillance.controllers').controller('CameraManagementController', [
  '$scope', '$rootScope', 'Camera', function ($scope, $rootScope, Camera) {

    // API
    $scope.getCameras = function () {
      $scope.isLoading = true;

      return Camera.query(
        function (data) {
          console.log('Loaded ' + data.length + ' cameras');
          console.debug(data);

          $scope.isLoading = false;
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to load network cameras',
            message: 'Sorry, an error occured while loading the network cameras.<br />' +
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

    $scope.addCamera = function () {
      $scope.inserted = {
        ipAddress: '',
        port: '8554',
        protocol: 'HTTP',
        name: ''
      };

      console.log('Adding camera');
      console.log(JSON.stringify($scope.inserted));

      // Add item to scope
      $scope.cameras.push($scope.inserted);
    };

    $scope.saveCamera = function (camera) {
      // TODO:
      //$scope.user not updated yet
      //angular.extend(data, {id: id});

      console.info('Saving camera #' + camera.id);
      console.debug(JSON.stringify(camera));

      Camera.save(data,
        function (data) {
          // do nothing
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to save network camera',
            message: 'Sorry, an error occured while saving the network camera.<br />' +
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
        }
      );
    };

    $scope.deleteCamera = function (camera) {
      console.info('Deleting camera #' + camera.id);
      console.debug(JSON.stringify(camera));

      camera.isBusy = true;
      $rootScope.$broadcast('removingStreamSource', $scope.getCameraStreamUrl(camera));

      return Camera.delete({ id: camera.id },
        function (data) {
          // Remove item from scope
          var index = $scope.cameras.indexOf(camera);
          $scope.cameras.splice(index, 1);
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to delete network camera',
            message: 'Sorry, an error occured while deleting the camera.<br />' +
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
          camera.isBusy = false;
        }
      );
    };

    // Attributes
    $scope.isLoading = true;
    $scope.cameras = $scope.getCameras();
    
    $scope.orderField = 'name';
    $scope.orderReverse = false;
    $scope.activeCamera = null;

    // Methods
    $scope.orderBy = function (field) {
      if ($scope.orderField === field) {
        $scope.orderReverse = !$scope.orderReverse;
      } else {
        $scope.orderReverse = false;
      }

      $scope.orderField = field;
    };

    $scope.cancelEditing = function (rowform, index) {
      // TODO: https://stackoverflow.com/questions/21336943/customize-the-cancel-code-button-of-the-x-editable-angularjs
      console.log(rowform, index);
      $scope.cameras.splice(index, 1);
      rowform.$cancel();
    }


    $scope.getCameraStreamUrl = function (camera) {
      return camera.protocol.toLowerCase() + '://' + camera.ipAddress + ':' + camera.port;
    }

    $scope.playStream = function (camera) {
      $scope.activeCamera = camera;
      $rootScope.$broadcast('playStream', $scope.getCameraStreamUrl(camera), 'video/mp4');
    };

    $scope.$on('playingStream', function (event, url, type) {
      if ($scope.activeCamera && url.toLowerCase() === $scope.getCameraStreamUrl($scope.activeCamera).toLowerCase()) {
        // New stream is the currently active camera
        return;
      }

      // Try to find a camera with the same stream URL as the new stream
      var streamIsCamera = false;
      angular.forEach($scope.cameras, function(camera) {
        if (!streamIsCamera && url.toLowerCase() === $scope.getCameraStreamUrl(camera).toLowerCase()) {
          console.info("Updating active camera (stream from camera was opened)");

          $scope.activeCamera = camera;
          streamIsCamera = true;
        }
      });

      // Remove active camera, stream URL doesn't match a camera
      if ($scope.activeCamera && !streamIsCamera) {
        console.info("Removing active camera (stream from unknown source was opened)");
        $scope.activeCamera = null;
      }
    });

    // Input validation
    $scope.validateName = function (data) {
      if (!data) {
        // Make sure data has value
        data = '';
      }

      // Validate name
      if (data.length > 32) {
        return "Name can't be longer than 32 characters";
      }

      return true;
    };

    $scope.validateIpAddress = function (data) {
      if (!data) {
        // Make sure data has value
        data = '';
      } else {
        // Remove all whitespaces
        data = data.toString().replace(/\s/g, '');
      }

      // Validate IPv4 address
      if (!/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/.test(data)) {
        return "Please enter a valid IPv4 address";
      }

      return true;
    };

    $scope.validatePort = function (data) {
      if (!data) {
        // Make sure data has value
        data = '';
      } else {
        // Remove all whitespaces
        data = data.toString().replace(/\s/g, '');
      }

      // Validate port
      if (data.length === 0 || data < 0 || data > 65535) {
        return "Please enter a valid port";
      }

      return true;
    };

    $scope.validateProcotol = function (data) {
      if (!data) {
        // Make sure data has value
        data = '';
      } else {
        // Remove all whitespaces
        data = data.toString().replace(/\s/g, '');
      }

      // Validate port
      if (data.length === 0 || data.length > 5) {
        return "Please enter a valid protocol";
      }

      return true;
    };

  }
]);

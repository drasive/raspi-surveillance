'use strict';

angular.module('raspiSurveillance.controllers').controller('CameraManagementController', [
  '$scope', '$rootScope', 'Camera', function ($scope, $rootScope, Camera) {

    // API
    $scope.getCameras = function (showModalOnError) {
      $scope.isLoading = true;

      return Camera.query(
        function (response) {
          console.log('Loaded ' + response.length + ' cameras');
          console.debug(response);

          $scope.hasError = false;
          $scope.isLoading = false;
        },
        function (response) {
          console.error(response);

          if (showModalOnError) {
            BootstrapDialog.show({
              title: 'Failed to load network cameras',
              message: 'Sorry, an error occured while loading the network cameras.<br />' +
                       'Please try again in a few moments.',
              type: BootstrapDialog.TYPE_DANGER,
              buttons: [
                {
                  label: 'Close',
                  cssClass: 'btn-primary',
                  action: function (dialogItself) {
                    dialogItself.close();
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

    $scope.addCamera = function () {
      $scope.inserted = {
        ipAddress: '',
        port: '8554',
        protocol: 'HTTP',
        name: ''
      };

      console.log('Adding camera');
      console.debug(JSON.stringify($scope.inserted));

      // Add item to scope
      $scope.cameras.push($scope.inserted);
    };

    $scope.saveCamera = function (camera, updatedProperties) {
      // Update model that was passed in
      // TODO: Reset to old model when operation failed because of existing duplicate (Or else new values stay when cancelling)
      var cameraOld = angular.copy(camera);

      angular.extend(camera, {
        name: updatedProperties.name,
        ipAddress: updatedProperties.ipAddress,
        port: updatedProperties.port,
        protocol: updatedProperties.protocol
      });

      if (camera.id) {
        // Camera already exists and gets updated
        console.info('Updating camera #' + camera.id);
        console.debug(JSON.stringify(camera));

        camera.isBusy = true;

        return Camera.update(camera).$promise.then(
          function (response) {
            camera.isBusy = false;

            // Update stream source
            // TODO: Only update stream if updated camera is currently active
            if ($scope.getCameraStreamUrl(camera) !== $scope.getCameraStreamUrl(cameraOld)) {
              $rootScope.$broadcast('removingStreamSource', $scope.getCameraStreamUrl(cameraOld));
              $rootScope.$broadcast('playStream', $scope.getCameraStreamUrl(camera), 'video/mp4');
            }
          },
          function (response) {
            // Camera already exists
            if (response.status === 400 && response.data.toLowerCase().indexOf('already exists') > -1) {
              console.warn('Camera already exists');

              BootstrapDialog.show({
                title: 'Camera already exists',
                message: 'A camera with the same IP address and port already exists.<br />' +
                         'Please change the IP address or port and save again.',
                type: BootstrapDialog.TYPE_WARNING,
                buttons: [
                  {
                    label: 'OK',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                      dialogItself.close();
                    }
                  }
                ]
              });

              camera.isBusy = false;
              return "Camera already exists";
            }

            // General error
            console.error(response);

            BootstrapDialog.show({
              title: 'Failed to update network camera',
              message: 'Sorry, an error occured while updating the network camera.<br />' +
                       'Please try again in a few moments.',
              type: BootstrapDialog.TYPE_DANGER,
              buttons: [
                {
                  label: 'Close',
                  cssClass: 'btn-primary',
                  action: function (dialogItself) {
                    dialogItself.close();
                  }
                }
              ]
            });

            camera.isBusy = false;
            return true;
          }
        );
      } else {
        // Camera doesn't exists and gets created
        console.info('Saving camera');
        console.debug(JSON.stringify(camera));

        camera.isBusy = true;

        return Camera.save(camera).$promise.then(
          function (response) {
            // Update local id
            camera.id = response.id;

            camera.isBusy = false;
          },
          function (response) {
            // Camera already exists
            if (response.status === 400 && response.data.toLowerCase().indexOf('already exists') > -1) {
              console.warn('Camera already exists');

              BootstrapDialog.show({
                title: 'Camera already exists',
                message: 'A camera with the same IP address and port already exists.<br />' +
                         'Please change the IP address or port and save again.',
                type: BootstrapDialog.TYPE_WARNING,
                buttons: [
                  {
                    label: 'Ok',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                      dialogItself.close();
                    }
                  }
                ]
              });

              camera.isBusy = false;
              return "Camera already exists";
            }

            // General error
            console.error(response);

            BootstrapDialog.show({
              title: 'Failed to save network camera',
              message: 'Sorry, an error occured while saving the network camera.<br />' +
                       'Please try again in a few moments.',
              type: BootstrapDialog.TYPE_DANGER,
              buttons: [
                {
                  label: 'Close',
                  cssClass: 'btn-primary',
                  action: function (dialogItself) {
                    dialogItself.close();
                  }
                }
              ]
            });

            camera.isBusy = false;
            return true;
          }
        );
      }
    };

    $scope.deleteCamera = function (camera) {
      console.info('Deleting camera #' + camera.id);
      console.debug(JSON.stringify(camera));

      camera.isBusy = true;
      $rootScope.$broadcast('removingStreamSource', $scope.getCameraStreamUrl(camera));

      return Camera.delete({ id: camera.id },
        function (response) {
          // Remove item from scope
          var index = $scope.cameras.indexOf(camera);
          $scope.cameras.splice(index, 1);
        },
        function (response) {
          console.error(response);

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
    $scope.hasError = false;
    $scope.cameras = $scope.getCameras(true);

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
      angular.forEach($scope.cameras, function (camera) {
        if (!streamIsCamera && url.toLowerCase() === $scope.getCameraStreamUrl(camera).toLowerCase()) {
          console.info("Highlighting camera (stream from camera was opened)");

          $scope.activeCamera = camera;
          streamIsCamera = true;
        }
      });

      // Remove active camera, stream URL doesn't match a camera
      if ($scope.activeCamera && !streamIsCamera) {
        console.info("Removing camera highlight (stream from other source was opened)");
        $scope.activeCamera = null;
      }
    });


    $scope.cancelEditing = function (camera, form) {
      if (camera.id) {
        // Camera already exists and would have been updated
        // do nothing
      } else {
        // Camera was new and would have been added
        var index = $scope.cameras.indexOf(camera);
        $scope.cameras.splice(index, 1);
      }

      form.$cancel();
    }

    // Input validation
    $scope.validateName = function (name) {
      if (!name) {
        // Make sure name has value
        name = '';
      }

      // Validate name
      if (name.length > 64) {
        return "Maximum 64 characters";
      }

      return true;
    };

    $scope.validateIpAddress = function (ipAddress) {
      if (!ipAddress) {
        // Make sure IP address has value
        ipAddress = '';
      } else {
        // Remove all whitespaces
        ipAddress = ipAddress.toString().replace(/\s/g, '');
      }

      // Validate IPv4 address
      if (ipAddress.length === 0) {
        return "IP address is required";
      }
      else if (!/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/.test(ipAddress)) {
        return "Invalid IPv4 address";
      }

      return true;
    };

    $scope.validatePort = function (port) {
      if (!port) {
        // Make sure port has value
        port = '';
      } else {
        // Remove all whitespaces
        port = port.toString().replace(/\s/g, '');
      }

      // Validate port
      if (port.length === 0) {
        return "Port is required";
      }
      else if (port < 0 || port > 65535) {
        return "Invalid port (0 to 65535)";
      }

      return true;
    };

    $scope.validateProtocol = function (protocol) {
      if (!protocol) {
        // Make sure protocol has value
        protocol = '';
      } else {
        // Remove all whitespaces
        protocol = protocol.toString().replace(/\s/g, '');
      }

      // Validate port
      if (protocol.length === 0) {
        return "Protocol is required";
      }
      else if (protocol.length > 5) {
        return "Maximum 5 characters";
      }

      return true;
    };

  }
]);

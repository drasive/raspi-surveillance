'use strict';

var raspiSurveillanceControllers = angular.module('raspiSurveillanceControllers', [
    'raspiSurveillanceServices',
    'raspiSurveillanceFilters',

    'ngSanitize',
    'com.2fdevs.videogular'
]);


raspiSurveillanceControllers.controller('CameraModeCtrl', [
  '$scope', function ($scope) {

    // TODO: Implement

    $scope.mode = 0;
    $scope.busy = false;

    $scope.changeMode = function (mode) {
      $scope.busy = true;

      var modeNames = ["Off", "Streaming", "Motion Detection"];
      console.info("Changing to mode \"" + modeNames[mode] + "\"");
      $scope.mode = mode;

      $scope.busy = false;
    }

  }
]);


raspiSurveillanceControllers.controller('LivestreamCtrl', [
  '$scope', '$sce', function ($scope, $sce) {

    // TODO: Remove when not needed anymore
    // { src: $sce.trustAsResourceUrl("http://static.videogular.com/assets/videos/videogular.mp4"), type: "video/mp4" },
    $scope.stream = {
      sources: [
          { src: $sce.trustAsResourceUrl("http://localhost:8554"), type: "video/mp4" }
      ],
      theme: "bower_components/videogular-themes-default/videogular.css",
      autoPlay: true
    };

    $scope.$on('loadStream', function (event, camera) {
      var url = camera.protocol.toLowerCase() + "://" + camera.ip_address + ':' + camera.port;
      var type = "video/mp4";

      // TODO: Remove when not needed anymore
      //url = "http://static.videogular.com/assets/videos/videogular.mp4";

      console.info('Changing to stream "' + url + '" (' + type + ")");
      $scope.stream.sources = [{ src: $sce.trustAsResourceUrl(url), type: type }];
    });

  }
]);

raspiSurveillanceControllers.controller('CameraManagementCtrl', [
  '$scope', '$rootScope', 'Camera', function ($scope, $rootScope, Camera) {

    // Fields
    $scope.cameras = Camera.query(
      function (data) {
        console.log('Loaded ' + data.length + ' cameras');
        console.debug(data);
      },
      function (error) {
        console.error(error);

        BootstrapDialog.show({
          title: 'Failed to load cameras',
          message: 'An error occured while loading the cameras.',
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

    $scope.orderField = 'name';
    $scope.orderReverse = false;

    // Validation
    // TODO: Allow same name?
    $scope.validateName = function (data, id) {
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

    $scope.validateIpAddress = function (data, id) {
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

    $scope.validatePort = function (data, id) {
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

    $scope.validateProcotol = function (data, id) {
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

    // Actions
    $scope.orderBy = function (field) {
      if ($scope.orderField === field) {
        $scope.orderReverse = !$scope.orderReverse;
      } else {
        $scope.orderReverse = false;
      }

      $scope.orderField = field;
    };


    $scope.loadStream = function (camera) {
      $rootScope.$broadcast('loadStream', camera);
    };

    $scope.addCamera = function () {
      console.log('Adding camera');

      $scope.inserted = {
        ip_address: '',
        port: '8554',
        protocol: 'HTTP',
        name: ''
      };

      console.debug(JSON.stringify($scope.inserted));

      // Add item to scope
      $scope.cameras.push($scope.inserted);
    };

    $scope.saveCamera = function (data, id) {
      // TODO:
      //$scope.user not updated yet
      //angular.extend(data, {id: id});

      console.info('Saving camera #' + id);
      console.debug(JSON.stringify(data));

      Camera.save(data,
        function (data) {
          // do nothing
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to save camera',
            message: 'An error occured while saving the camera.',
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

      return Camera.delete({ id: camera.id },
        function (data) {
          // Remove item from scope
          var index = $scope.cameras.indexOf(camera);
          $scope.cameras.splice(index, 1);
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to delete camera',
            message: 'An error occured while deleting the camera.',
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

    $scope.cancelEditing = function (rowform, index) {
      // TODO:https://stackoverflow.com/questions/21336943/customize-the-cancel-code-button-of-the-x-editable-angularjs
      console.log(rowform, index);
      $scope.cameras.splice(index, 1);
      rowform.$cancel();
    }
  }
]);


raspiSurveillanceControllers.controller('VideoCtrl', [
  '$scope', '$sce', function ($scope, $sce) {

    // TODO: Test auto play here and in livestream
    $scope.stream = {
      sources: [],
      theme: "bower_components/videogular-themes-default/videogular.css",
      autoPlay: true
    };

    $scope.$on('loadVideo', function (event, video) {
      var url = "/videos/" + video.filename;
      var type = "video/mp4";

      console.info('Changing to video "' + url + '" (' + type + ")");
      $scope.stream.sources = [{ src: $sce.trustAsResourceUrl(url), type: type }];
      // TODO: Start video
    });

  }
]);

raspiSurveillanceControllers.controller('VideoManagementCtrl', [
  '$scope', '$rootScope', 'Video', function ($scope, $rootScope, Video) {

    // Fields
    $scope.videos = Video.query(
      function (data) {
        console.log('Loaded ' + data.length + ' videos');
        console.debug(data);
      },
      function (error) {
        console.error(error);

        BootstrapDialog.show({
          title: 'Failed to load videos',
          message: 'An error occured while loading the videos.',
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

    $scope.orderField = 'created_at';
    $scope.orderReverse = false;

    // Actions
    $scope.orderBy = function (field) {
      if ($scope.orderField === field) {
        $scope.orderReverse = !$scope.orderReverse;
      } else {
        $scope.orderReverse = false;
      }

      $scope.orderField = field;
    };


    $scope.loadVideo = function (video) {
      $rootScope.$broadcast('loadVideo', video);
    };

    $scope.deleteVideo = function (video) {
      console.info('Deleting video "' + video.filename + '"');
      console.debug(JSON.stringify(video));

      return Video.delete({ filename: video.filename },
        function (data) {
          // Remove item from scope
          var index = $scope.videos.indexOf(video);
          $scope.videos.splice(index, 1);
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to delete video',
            message: 'An error occured while deleting the video.',
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

  }
]);

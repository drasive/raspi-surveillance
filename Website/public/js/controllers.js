'use strict';

var raspiSurveillanceControllers = angular.module('raspiSurveillanceControllers', [
    'raspiSurveillanceServices',
    'raspiSurveillanceFilters',

    'ngSanitize',
    'com.2fdevs.videogular'
]);


raspiSurveillanceControllers.controller('CameraModeCtrl', [
  '$scope',function ($scope) {

    // TODO: Implement

    var modes = ['Off', 'Streaming', 'Motion Detection'];

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

raspiSurveillanceControllers.controller('LivestreamCtrl', [
  '$scope', '$sce', function ($scope, $sce) {

    // Attributes
    $scope.onPlayerReady = function onPlayerReady(videoPlayer) {
      $scope.videoPlayer = videoPlayer;
    };

    $scope.stream = {
      sources: [
          { src: $sce.trustAsResourceUrl('http://localhost:8554'), type: 'video/mp4' }
      ],
      theme: 'bower_components/videogular-themes-default/videogular.css',
      autoPlay: true
    };
    $scope.camera = null;

    // Actions
    $scope.$on('loadStream', function (event, camera) {
      var url = camera.protocol.toLowerCase() + '://' + camera.ipAddress + ':' + camera.port;
      var type = 'video/mp4';
      console.info('Playing stream "' + url + '" (' + type + ')');

      $scope.camera = camera;
      $scope.stream.sources = [{ src: $sce.trustAsResourceUrl(url), type: type }];
      $scope.videoPlayer.play();
    });

    $scope.$on('deletingCamera', function (event, camera) {
      if ($scope.camera == camera) {
        console.info('Stopping livestream playback (network camera is getting deleted)');

        $scope.videoPlayer.stop();
        $scope.stream.sources = [];
        $scope.camera = null;
      }
    });

  }
]);

raspiSurveillanceControllers.controller('CameraManagementCtrl', [
  '$scope', '$rootScope', 'Camera', function ($scope, $rootScope, Camera) {

    // TODO: Implement isBusy

    // Attributes
    $scope.cameras = Camera.query(
      function (data) {
        console.log('Loaded ' + data.length + ' cameras');
        console.debug(data);
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
        ipAddress: '',
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
      $rootScope.$broadcast('deletingCamera', camera);

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
    
    $scope.cancelEditing = function (rowform, index) {
      // TODO: https://stackoverflow.com/questions/21336943/customize-the-cancel-code-button-of-the-x-editable-angularjs
      console.log(rowform, index);
      $scope.cameras.splice(index, 1);
      rowform.$cancel();
    }

  }
]);


raspiSurveillanceControllers.controller('VideoPlayerCtrl', [
  '$scope', '$sce', function ($scope, $sce) {

    // Attributes
    $scope.onPlayerReady = function onPlayerReady(videoPlayer) {
      $scope.videoPlayer = videoPlayer;
    };

    $scope.stream = {
      sources: [],
      theme: 'bower_components/videogular-themes-default/videogular.css',
      autoPlay: true
    };
    $scope.video = null;

    // Actions
    $scope.$on('loadVideo', function (event, video) {
      var url = '/videos/' + video.filename;
      var type = 'video/mp4';

      console.info('Playing video "' + url + '" (' + type + ')');

      $scope.video = video;
      $scope.stream.sources = [{ src: $sce.trustAsResourceUrl(url), type: type }];
      $scope.videoPlayer.play();
    });

    $scope.$on('deletingVideo', function (event, video) {
      if ($scope.video == video) {
        console.info('Stopping video playback (video is getting deleted)');

        $scope.videoPlayer.stop();
        $scope.stream.sources = [];
        $scope.video = null;
      }
    });

  }
]);

raspiSurveillanceControllers.controller('VideoManagementCtrl', [
  '$scope', '$rootScope', 'Video', function ($scope, $rootScope, Video) {

    // Attributes
    $scope.videos = Video.query(
      function (data) {
        console.log('Loaded ' + data.length + ' videos');
        console.debug(data);
      },
      function (error) {
        console.error(error);

        BootstrapDialog.show({
          title: 'Failed to load surveillance videos',
          message: 'Sorry, an error occured while loading the surveillance videos.<br />' +
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

    $scope.orderField = 'createdAt';
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

      video.isBusy = true;
      $rootScope.$broadcast('deletingVideo', video);

      return Video.delete({ filename: video.filename },
        function (data) {
          // Remove item from scope
          var index = $scope.videos.indexOf(video);
          $scope.videos.splice(index, 1);
        },
        function (error) {
          console.error(error);

          BootstrapDialog.show({
            title: 'Failed to delete surveillance video',
            message: 'Sorry, an error occured while deleting the surveillance video.<br />' +
                     'Please try again in a few moments.',
            type: BootstrapDialog.TYPE_DANGER,
            buttons: [
              {
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself) {
                  dialogItself.close();
                }
              }
            ]
          });
          video.isBusy = false;
        });
    };

  }
]);

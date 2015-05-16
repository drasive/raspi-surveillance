'use strict';

angular.module('raspiSurveillance.controllers').controller('VideoManagementController', [
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
      $rootScope.$broadcast('removingVideo', video);

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

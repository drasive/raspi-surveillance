'use strict';

angular.module('raspiSurveillance.controllers').controller('VideoManagementController', [
  '$scope', '$rootScope', 'Video', function($scope, $rootScope, Video) {

    // API
    $scope.getVideos = function (showModalOnError) {
      $scope.isLoading = true;

      return Video.query(
       function (response) {
         console.log('Loaded ' + response.length + ' videos');
         console.debug(response);

         $scope.hasError = false;
         $scope.isLoading = false;
       },
       function (response) {
         console.error(response);

         if (showModalOnError) {
           BootstrapDialog.show({
             title: 'Failed to load surveillance videos',
             message: 'Sorry, an error occured while loading the surveillance videos.<br />' +
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
    };

    $scope.deleteVideo = function (video) {
      var videoDisplayName = video.createdAtFormatted + ' (' + video.durationFormatted + ', ' + video.sizeFormatted + ')';

      BootstrapDialog.show({
        title: 'Really delete surveillance video from ' + video.createdAtFormatted + '?',
        message: 'Do you really want to delete the surveillance video recorded at ' + videoDisplayName + '?'
               + '<br />A deleted surveillance video cannot be restored.',
        type: BootstrapDialog.TYPE_WARNING,
        buttons: [{
          label: 'Yes',
          cssClass: 'btn-danger',
          action: function (dialog) {
            console.info('Deleting video "' + video.filename + '"');
            console.debug(JSON.stringify(video));

            video.isBusy = true;
            $rootScope.$broadcast('removingVideo', $scope.getVideoUrl(video));

            dialog.close();

            return Video.delete({ filename: video.filename },
              function (response) {
                // Remove item from scope
                var index = $scope.videos.indexOf(video);
                $scope.videos.splice(index, 1);
              },
              function (response) {
                console.error(response);

                BootstrapDialog.show({
                  title: 'Failed to delete surveillance video',
                  message: 'Sorry, an error occured while deleting the surveillance video.<br />' +
                           'Please try again in a few moments.',
                  type: BootstrapDialog.TYPE_DANGER,
                  buttons: [
                    {
                      label: 'Close',
                      cssClass: 'btn-primary',
                      action: function (dialog) {
                        dialog.close();
                      }
                    }
                  ]
                });

                video.isBusy = false;
              });
          }
        }, {
          label: 'No',
          cssClass: 'btn-primary',
          action: function (dialog) {
            dialog.close();
          }
        }]
      });
    };

    // Attributes
    $scope.isLoading = true;
    $scope.hasError = false;
    $scope.videos = $scope.getVideos(true);

    $scope.orderField = 'createdAt';
    $scope.orderReverse = true;
    $scope.activeVideo = null;

    // Methods
    $scope.orderBy = function (field) {
      if ($scope.orderField === field) {
        $scope.orderReverse = !$scope.orderReverse;
      } else {
        $scope.orderReverse = false;
      }

      $scope.orderField = field;
    };


    $scope.getVideoUrl = function(video) {
      return 'videos/' + video.filename;
    }

    $scope.playVideo = function (video) {
      $scope.activeVideo = video;
      $rootScope.$broadcast('playVideo', $scope.getVideoUrl(video), 'video/avi');
    };
   
  }
]);

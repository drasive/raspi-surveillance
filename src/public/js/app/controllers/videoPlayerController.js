'use strict';

angular.module('raspiSurveillance.controllers').controller('VideoPlayerController', [
  '$scope', function ($scope) {
    
    // TODO: Revert back to native video player, or refactor and clean up

    // Attributes
    $scope.videoUrl = null;

    // Actions
    $scope.initialize = function () {
      $scope.videoPlayerContainer = $('#video-player-container');

      $scope.resizeVideoPlayer();
    }

    $scope.resizeVideoPlayer = function () {
      if ($("#video-player")) {
        var width = $("[ng-controller=VideoPlayerController]").width();
        var height = width * 9 / 16; // 16:9 relation

        var videoPlayer = $('#video-player embed');
        videoPlayer.width(width);
        videoPlayer.height(height);
      }
    }


    $scope.$on('playVideo', function (event, url, type) {
      console.info('Playing video "' + url + '" (' + type + ')');
      $scope.videoUrl = url;

      // Add/ replace video player
      var videoPlayer = '<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" id="video-player">';
      videoPlayer += '    <param name="Src" value="' + url + '" />';
      videoPlayer += '    <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" name="vlc"';
      videoPlayer += '      width="640" height="480" src="' + url + '" />';
      videoPlayer += '</object>';
      $scope.videoPlayerContainer.html(videoPlayer);

      $scope.resizeVideoPlayer();
    });

    $scope.$on('removingVideo', function (event, url) {
      if ($scope.videoUrl && url.toLowerCase() === $scope.videoUrl.toLowerCase()) {
        $scope.videoUrl = null;
        console.info('Stopping video (video is being removed)');

        // Remove video player
        $scope.videoPlayerContainer.html('');
      }
    });

    $scope.initialize();

  }
]);

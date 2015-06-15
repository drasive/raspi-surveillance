'use strict';

angular.module('raspiSurveillance.controllers').controller('LivestreamController', [
  '$scope', '$rootScope', function ($scope, $rootScope) {

    // Attributes
    $scope.streamUrl = null;

    // Actions
    $scope.initialize = function () {
      $scope.videoPlayerContainer = $('#video-player-container');

      $scope.resizeVideoPlayer();
    }

    $scope.resizeVideoPlayer = function () {
      if ($("#video-player").length > 0) {
        var width = $("[ng-controller=LivestreamController]").width();
        var height = width * 9 / 16; // 16:9 relation

        var videoPlayer = $('#video-player embed');
        videoPlayer.prop("width", width);
        videoPlayer.prop("height", height);
      }
    }


    $scope.playStream = function (url, type) {
      if ($scope.streamUrl && url.toLowerCase() === $scope.streamUrl.toLowerCase()) {
        console.log('Already playing livestream "' + url + '" (' + type + ')');
        return;
      }

      console.info('Playing livestream "' + url + '" (' + type + ')');
      $scope.streamUrl = url;

      $rootScope.$broadcast('playingStream', url, type);

      // Add /replace video player
      var videoPlayer = '<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab" id="vlc-player">';
      videoPlayer += '    <param name="Src" value="' + url + '" />';
      videoPlayer += '    <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" name="vlc"';
      videoPlayer += '      width="640" height="480" target="' + url + '" />';
      videoPlayer += '</object>';
      $scope.videoPlayerContainer.html(videoPlayer);

      $scope.resizeVideoPlayer();
    }

    $scope.$on('playStream', function (event, url, type) {
      $scope.playStream(url, type);
    });

    $scope.playStreamFromUrl = function () {
      $scope.playStream($scope.customUrl, 'video/mp4');
    }

    $scope.$on('removingStreamSource', function (event, url) {
      if ($scope.streamUrl && url.toLowerCase() === $scope.streamUrl.toLowerCase()) {
        $scope.streamUrl = null;
        console.info('Stopping livestream (stream source "' + url + '" is being removed)');

        // Remove video player
        $scope.videoPlayerContainer.html('');
      }
    });

    $scope.initialize();

  }
]);

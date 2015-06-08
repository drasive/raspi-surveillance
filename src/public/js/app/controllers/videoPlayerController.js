'use strict';

angular.module('raspiSurveillance.controllers').controller('VideoPlayerController', [
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

    // Actions
    $scope.$on('playVideo', function (event, url, type) {
      console.info('Playing video "' + url + '" (' + type + ')');

      $scope.stream.sources = [{ src: $sce.trustAsResourceUrl(url), type: type }];
      $scope.videoPlayer.play();
    });

    $scope.$on('removingVideo', function (event, url) {
      if ($scope.stream.sources.length === 0) {
        return;
      }

      if (url.toLowerCase() === $sce.getTrustedResourceUrl($scope.stream.sources[0].src).toLowerCase()) {
        console.info('Stopping video (video is being removed)');

        $scope.videoPlayer.stop();
        $scope.stream.sources = [];
      }
    });

  }
]);

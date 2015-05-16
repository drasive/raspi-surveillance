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

    $scope.$on('removingVideo', function (event, video) {
      if ($scope.video == video) {
        console.info('Stopping video (video is being removed)');

        $scope.videoPlayer.stop();
        $scope.stream.sources = [];
        $scope.video = null;
      }
    });

  }
]);

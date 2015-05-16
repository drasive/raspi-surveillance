'use strict';

angular.module('raspiSurveillance.controllers').controller('LivestreamController', [
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
      console.info('Playing livestream "' + url + '" (' + type + ')');

      $scope.camera = camera;
      $scope.stream.sources = [{ src: $sce.trustAsResourceUrl(url), type: type }];
      $scope.videoPlayer.play();
    });

    $scope.$on('removingStreamSource', function (event, camera) {
      if ($scope.camera == camera) {
        console.info('Stopping livestream (stream source is being removed)');

        $scope.videoPlayer.stop();
        $scope.stream.sources = [];
        $scope.camera = null;
      }
    });

  }
]);

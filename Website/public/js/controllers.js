'use strict';

var raspiSurveillanceControllers = angular.module('raspiSurveillanceApp', ['raspiSurveillanceServices']);

raspiSurveillanceControllers.controller('LivestreamCtrl', ['$scope', 'Camera', function ($scope, Camera) {
    
    $scope.streamSource = 'localhost:8554';
    
    $scope.$on('loadingStream', function(event, camera) {
        console.log('changing stream');
        $scope.streamSource = camera.ip_address + ':' + camera.port;
    });
    
}]);

raspiSurveillanceControllers.controller('CameraManagementCtrl', ['$scope', '$rootScope', 'Camera', function ($scope, $rootScope, Camera) {
    
    // Fields
    $scope.cameras = Camera.query(
        function (data) {
            // do nothing
        },
        function (error) {
            // TODO:
            alert('query error');
        }
    );
    $scope.orderField = 'name';
    $scope.orderReverse = false;
    
     // Validation
    //$scope.validateIpAddress = function(data, id) {
    //    if (id === 2 && data !== 'awesome') {
    //        return "Username 2 should be `awesome`";
    //    }
    //};
    //
    //$scope.validateName = function(data, id) {
    //    if (id === 2 && data !== 'awesome') {
    //        return "Username 2 should be `awesome`";
    //    }
    //};
    
    // Actions
    $scope.orderBy = function(field) {
        if ($scope.orderField === field) {
            $scope.orderReverse = !$scope.orderReverse;
        }
        else {
            $scope.orderReverse = false;
        }
        
        $scope.orderField = field;
    }
    
    
    $scope.loadStream = function(camera) {
        $rootScope.$broadcast('loadingStream', camera);
    }
    
    $scope.addCamera = function() {
        $scope.inserted = {
            ip_address: '',
            port: '8554',
            name: ''
        };
        
        return Camera.add({ id: camera.id},
            function (data) {
                // Add item to scope
                $scope.cameras.push($scope.inserted);
            },
            function(error) {
                // TODO:
                alert("Add error");
            }
        );
    };
    
    $scope.saveCamera = function(data, id) {
        // TODO:
        //$scope.user not updated yet
        //angular.extend(data, {id: id});
        
        console.log('saving');
        Camera.save(data,
            function (data) {
                // do nothing
            },
            function (error) {
                // TODO:
                alert('saving error');
            }
        );
    };
    
    $scope.deleteCamera = function(camera) {
        console.log('deleting');
        
        return Camera.delete({ id: camera.id},
            function(data) {
                // Remove item from scope
                var index = $scope.cameras.indexOf(camera);
                $scope.cameras.splice(index, 1);
            },
            function(error) {
                // TODO:
                alert("Delete error");
            }
        );
    };
    
}]);

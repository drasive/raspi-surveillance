'use strict';

var raspiSurveillanceControllers = angular.module('raspiSurveillanceApp', ['raspiSurveillanceServices']);

raspiSurveillanceControllers.controller('CameraListCtrl', ['$scope', 'Camera', function ($scope, Camera) {
	
	// Fields
	$scope.cameras = Camera.query();
	$scope.orderField = 'ip_address';
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
	
	
    $scope.addCamera = function() {
        $scope.inserted = {
            ip_address: '',
            name: ''
        };
        
        $scope.cameras.push($scope.inserted);
    };
    
    $scope.saveCamera = function(data, id) {
        //$scope.user not updated yet
        //angular.extend(data, {id: id});
        console.log('save');
        Camera.save(data);
    };
    
    $scope.deleteCamera = function(camera) {
        // TODO: Disable delete button during AJAX request, re-enable on error
        alert("Deleting");
        
        console.log('deleting');
        return Camera.delete({ id: camera.id}).$promise
            .then(function(value) {
                // Remove item from array
                var index = $scope.cameras.indexOf(camera);
                $scope.cameras.splice(index, 1);
            })
            .catch(function(error) {
                alert("Delete failed");
            })
    };
	
}]);

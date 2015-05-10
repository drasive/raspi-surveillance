'use strict';

var raspiSurveillanceDirectives = angular.module('raspiSurveillanceDirectives', []);

raspiSurveillanceDirectives.directive('clickDisable', function() {
    console.log('click-disable-1');
    
    return {
        restrict: 'A',
        scope: {
            clickDisable: '&'
        },
        link: function(scope, element, attrs) {
            console.log('click-disable-2');
            
            element.bind('click', function() {
                element.prop('disabled', true);
                
                scope.clickDisable().finally(function() {
                    element.prop('disabled', false);
                });
            });
        }
    };
});

raspiSurveillanceDirectives.directive('clickAndDisable', function() {
  return {
    scope: {
      clickAndDisable: '&'
    },
    link: function(scope, iElement, iAttrs) {
      iElement.bind('click', function() {
        iElement.prop('disabled',true);
        scope.clickAndDisable().finally(function() {
          iElement.prop('disabled',false);
        })
      });
    }
  };
});

raspiSurveillanceDirectives.directive('test', function() {
    //console.log('test-1');
    
	return {
		replace : true,
		template: '<input type="text" placeholder="Test" id="test">'
	};
    //return {
    //    restrict: 'A',
    //    scope: {
    //        clickDisable: '&'
    //    },
    //    link: function(scope, element, attrs) {
	//		console.log('1-2');
	//		
    //        element.bind('click', function() {
    //            element.prop('disabled', true);
    //            
    //            scope.clickDisable().finally(function() {
    //                element.prop('disabled', false);
    //            });
    //        });
    //    }
    //};
});

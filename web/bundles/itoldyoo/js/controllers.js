'use strict';

/* Controllers */

var iToldYooControllers = angular.module('iToldYooControllers', []);

iToldYooControllers.controller('mainController', function($scope,$window) {
   
    //$scope.mode="new";
    $scope.isMobile = function(){
      var screenWidth = $window.innerWidth;
      if (screenWidth < 768) {
        return true;
      }
      return false;
    }
    $scope.mobile = $scope.isMobile();
   
});
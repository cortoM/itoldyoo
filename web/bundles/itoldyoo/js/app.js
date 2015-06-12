'use strict';

/* App Module */

var iToldYooApp = angular.module('iToldYooApp', [
  'ngRoute',
  'iToldYooControllers',
  'iToldYooServices',
  'iToldYooComponents',
  'dateTimeServices',
  'iToldYooFilters'

]);

/*phonecatApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/phones', {
        templateUrl: 'partials/phone-list.html',
        controller: 'PhoneListCtrl'
      }).
      when('/phones/:phoneId', {
        templateUrl: 'partials/phone-detail.html',
        controller: 'PhoneDetailCtrl'
      }).
      otherwise({
        redirectTo: '/phones'
      });
  }]);*/



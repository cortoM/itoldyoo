'use strict';

/* Filters */

/*angular.module('phonecatFilters', []).filter('checkmark', function() {
  return function(input) {
    return input ? '\u2713' : '\u2718';
  };
});
*/
var iToldYooFilters = angular.module('iToldYooFilters', []);

iToldYooFilters.filter('time',function () {
	return function(date){
    	return ('0' + date.getHours()).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2);
	};
});

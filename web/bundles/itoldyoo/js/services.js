'use strict';

/* Services */

var iToldYooServices = angular.module('iToldYooServices', []);

iToldYooServices.factory('itemRessource', ['$http', function($http) {

	return {
		
		baseUrl: "../",

		createITolydoo: function(postData){
        	return $http({
            	url: this.baseUrl + "user/createIToldyoo",
            	data: postData,
			   	method: "post",
			   	headers: {'Content-Type': 'application/json'}
        	})
		},
		getIToldyoo: function(){
        	return $http({
            	url: this.baseUrl + "user/getIToldyoo",
			   	method: "get"
        	})
		},
		getEmails: function(){
        	return $http({
            	url: this.baseUrl + "user/getEmails",
			   	method: "get"
        	})
		},
		getUserLastEmail: function(){
        	return $http({
            	url: this.baseUrl + "user/getUserLastEmail",
			   	method: "get"
        	})
		}

	};

}])

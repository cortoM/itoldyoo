'use strict';

/* Services */

var iToldYooServices = angular.module('iToldYooServices', []);

iToldYooServices.factory('itemRessource', ['$http', function($http) {

	return {
		baseUrl: "http://localhost:8001",
		//baseUrl: "",

		updateItem: function(item) {
        	return $http({
            	url: this.baseUrl + "/item/" + item.itemId,
			   	method: "post",
		   		data: item
        	})
    	},

		getItem: function(itemId){
        	return $http({
            	url: this.baseUrl + "/item/" + itemId,
			   	method: "get"
        	})
		},
		getItems: function(){
        	return $http({
            	url: this.baseUrl + "/items/all.json",
			   	method: "get"
        	})
		},
		getStates: function(){
        	return $http({
            	url: this.baseUrl + "/app/emails.json",
			   	method: "get"
        	})
		}


	};

}])

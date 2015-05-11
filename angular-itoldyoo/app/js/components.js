'use strict';

/* Components */

var iToldYooComponents = angular.module('iToldYooComponents', []);

iToldYooComponents.directive('whenpicker', function() {

    return {
		restrict: 'E',
		transclude: true,
		templateUrl: 'components/datetimepicker.html',
		scope: { 
				prompt:'@',
		},
		link: function(scope){
   			var result = {"component" : "whenpicker"};
   			scope.$emit('itoldyoo-loaded-response', result);		
		},
   		controller: function($rootScope, $scope, dateTimeHelper) {
   			$scope.finalDate = $scope.prompt;
   			$scope.template = "";
   			$scope.isOpen = false;

   			$scope.$on('itoldyoo-loaded-request', function(event, args) {
   				var result = {"component" : "whenpicker"};
// 				$scope.$emit('itoldyoo-loaded-response', result);
			});

   			$scope.$on('itoldyoo-save-request', function(event, args) {
   				var result = $scope.validateValues();
   				$scope.$emit('itoldyoo-save-response', result);
			});

   			$scope.validateValues = function(){
				if ((typeof $scope.myDate == 'undefined') || ($scope.myDate == null)){
					var result = {"valid" : false,
						"component" : "whenpicker"};
					return result;	
				}
				else{
					var result = {"valid" : true,
						"date" : $scope.myDate,
						"component" : "whenpicker"};
					return result;
				}
   			}

			$scope.handleChangeDateTime = function(){
				
				if ($scope.isOpen == false){
					$scope.nextView('none');
					$scope.isOpen = true;
				}
				else{
					$scope.isOpen = false;
					$scope.setDateTimeView('none');
				}
				
			}

			$scope.move = function(nb){
				
				switch ($scope.template) {
					case 'year':
						$scope.displayedDate.setFullYear($scope.displayedDate.getFullYear() + nb);
						$scope.years = dateTimeHelper.getVisibleYears($scope.displayedDate);
						break;
					case 'month':
						$scope.displayedDate.setFullYear($scope.displayedDate.getFullYear() + nb);
						$scope.months = dateTimeHelper.getVisibleMonths($scope.displayedDate);
						break;
					case 'day':
						$scope.displayedDate.setMonth($scope.displayedDate.getMonth() + nb);
						$scope.days = dateTimeHelper.getDaysOfWeek($scope.displayedDate);
						$scope.weeks = dateTimeHelper.getVisibleWeeks($scope.displayedDate);
						break;
					case 'hour':
						$scope.displayedDate.setHours($scope.displayedDate.getHours() + nb);
						$scope.hours = dateTimeHelper.getVisibleHours($scope.displayedDate);
						break;
				}
			}

			$scope.nextView = function(view){
				
				switch(view){
					case 'year':
						$scope.months = dateTimeHelper.getVisibleMonths($scope.displayedDate);
						$scope.setDateTimeView('month');
						break;
					case 'month':
						$scope.days = dateTimeHelper.getDaysOfWeek($scope.displayedDate);
						$scope.weeks = dateTimeHelper.getVisibleWeeks($scope.displayedDate);
						$scope.setDateTimeView('day');
						break;
					case 'day':
						$scope.hours = dateTimeHelper.getVisibleHours($scope.displayedDate);
						$scope.setDateTimeView('hour');
						break;
					default:{
						
						if ($scope.finalDate === $scope.prompt){
							//init - first click on the component
							
							$scope.years = dateTimeHelper.getVisibleYears(new Date());
							$scope.displayedDate = new Date();
							$scope.selectedDate = new Date();
						}
						else{
							$scope.years = dateTimeHelper.getVisibleYears($scope.displayedDate);
						}
						
						$scope.setDateTimeView('year');
					}

				}
			}

			$scope.setSelectedDate = function(date, view){
				$scope.selectedDate = new Date(date);
				$scope.displayedDate = new Date(date);
				
				if (view === 'hour'){
					$scope.finalDate = new Date(date);
					$scope.myDate = new Date(date);
					$scope.setDateTimeView('none');
					$scope.isOpen = false;
				}
				else{
					$scope.nextView(view);
				}

			}

			$scope.setDateTimeView = function(view){
				$scope.template = view;
			}

		}
	};
});   

iToldYooComponents.directive('emailbox', function($timeout) {
	 // keyboard events
	var KEY_UP = 38;
	var KEY_DW = 40;
	var KEY_ESC = 27;
	var KEY_ENT = 13;
	var KEY_BACK = 8;

  	return {
    restrict: 'E',
    transclude: true,
    scope: {},
	link:function(scope,elem,attrs){
		scope.handleSelection=function(selectedItem){
			scope.addEmailList(scope.items[scope.current].email);
			scope.handleFocus();
		};
		scope.handleFocus = function (){
			var element = document.getElementById("type-ahead-element-input-text");
        	if(element)
          		element.focus();
		};
		scope.handleKeyUp=function(event){
			var value = event.which ? event.which : event.keyCode;

			if (value === KEY_UP) {
				event.preventDefault();
				if (scope.current > 0) 
					scope.current--;
			}
			else if (value === KEY_DW) {
				event.preventDefault();
				if (scope.current <scope.items.length-1) 
					scope.current++;
			}
			else if (value === KEY_ESC) {
				event.preventDefault();
				scope.clearItemList();
			}
			else if (value === KEY_BACK) {
				event.preventDefault();
				if (scope.search.length == 0){
					scope.emailList.pop();
				}
			}
			else if (value === KEY_ENT) {
				event.preventDefault();
				if(scope.current >= 0){
					scope.addEmailList(scope.items[scope.current].email);
				}
				else{
					var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    				if (re.test(scope.search))
						scope.addEmailList(scope.search);
				}
				scope.handleFocus();
			}
		}

		scope.isCurrent=function(index){
			return scope.current==index;
		};
		
		scope.setCurrent=function(index){
			scope.current=index;
		};
		scope.getCurrent=function(index){
			return scope.current;
		};

		var result = {"component" : "emailbox"};
		scope.$emit('itoldyoo-loaded-response', result);

	},
	controller: function($rootScope, $scope, $http, itemRessource){
				
		$scope.items = [];
		$scope.emailList = [];

		$scope.$on('itoldyoo-loaded-request', function(event, args) {
			var result = {"component" : "emailbox"};
		//	$scope.$emit('itoldyoo-loaded-response', result);
		});

		$scope.$on('itoldyoo-save-request', function(event, args) {
			var result = $scope.validateValues();
			$scope.$emit('itoldyoo-save-response', result);
		});

		$scope.validateValues = function(){
			if ((typeof $scope.emailList == 'undefined') || ($scope.emailList.length == 0)) {
				var result = {"valid" : false,
					"component" : "emailbox"};
				return result;	
			}
			else{
				var result = {"valid" : true,
					"emails" : $scope.emailList,
					"component" : "emailbox"};
				return result;

			}
		}

		$scope.filterEmails=function(keyPhrase, nbItems){
			$scope.items = [];
			if (!keyPhrase.length > 0) return;
			//first loop
			for(var i= 0; i < $scope.master.length; i++){
				if ($scope.items.length < nbItems){
					if ($scope.master[i].email.indexOf(keyPhrase) == 0){
						$scope.items.push($scope.master[i]);	
					}
				}
				else{
					break;
				}
			}
			//second loop
			if ($scope.items.length < nbItems){
				for(var i= 0; i < $scope.master.length; i++){
					if ($scope.items.length < nbItems){
						if ($scope.master[i].email.indexOf(keyPhrase) > 0){
							//TODO check if no dupliation
							$scope.items.push($scope.master[i]);	
						}
					}
					else{
						break;
					}
				}
			}
			if ($scope.items.length > 0){
				$scope.current = 0;
			}
			else{
				$scope.current = -1;	
			}
		}

		$scope.handleRemoveEmail=function(index){
			$scope.emailList.splice(index, 1);
		}

		$scope.clearItemList=function(){
			$scope.items = [];
			$scope.current = -1;
			$scope.search = "";
		}

		$scope.addEmailList=function(email){
			$scope.emailList.push(email);
			$scope.clearItemList();
		}


	  	itemRessource.getStates()
		.success(function (data, status, headers, config) {
			if (data.code == 200){
				$scope.master = angular.copy(data.content);
            }
    	})
    	.error(function (data, status, headers, config) {
        	$scope.data = data;
        	$scope.status = status;
    	});

   		$scope.name="";
		$scope.onItemSelected=function(){
			console.log('selected='+$scope.name);
		}


	},
    templateUrl: 'components/emailbox2.html'
  }
});

iToldYooComponents.directive('itoldyooheader', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
		templateUrl: 'components/header.html',
   		controller: function($scope) {


		},
		replace: true
	};
});

iToldYooComponents.directive('itoldyoofooter', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
		templateUrl: 'components/footer.html',
   		controller: function($scope) {


		},
		replace: true
	};
});

iToldYooComponents.directive('itoldyoo', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
		templateUrl: 'components/itoldyoo.html',
		link: function(scope){
   			
		},
   		controller: function($scope) {
   			
   			$scope.mode="view";

   			$scope.childComponents = [];
   			$scope.childComponentValues = [];
   			$scope.childComponentValid = true;
   			//$scope.inputemail = "ee";
   			//local components
   			$scope.childComponents.push("inputitoldyoo");
   			$scope.childComponents.push("inputemail");
   			//$scope.isInputemailValid = true;
   			//remote component
			$scope.$on('itoldyoo-loaded-response', function(event, args) {
				$scope.childComponents.push(args.component);
			});

			$scope.$on('itoldyoo-save-response', function(event, args) {
				$scope.childComponentValues.push(args);
				if (args.valid != true){
					$scope.childComponentValid = false;
				}
				if (($scope.childComponents.length == $scope.childComponentValues.length) && ($scope.childComponentValid == true)){
					//TODO call server API
					//$scope.inputitoldyoo="";
					//$scope.mode="view";
					alert("validation OK");
				}
				else if (($scope.childComponents.length == $scope.childComponentValues.length) && ($scope.childComponentValid == false)){
					alert("validation KO");
				}
			});

   			$scope.validateValues = function(){
   				$scope.inputitoldyoo2 = $("#inputitoldyoo2").val();
				var result = null;
   				if ((typeof $scope.inputitoldyoo2 == 'undefined') || ($scope.inputitoldyoo2.length == 0)){
					result = {"valid" : false,
						"component" : "inputitoldyoo"};
					$scope.isInputitoldyooValid = false;
				}
				else{
					result = {"valid" : true,
						"message" : $scope.inputitoldyoo2,
						"component" : "inputitoldyoo"};
					$scope.isInputitoldyooValid = true;					

				}   					//error
   				$scope.childComponentValues.push(result);
   				if (result.valid != true){
					$scope.childComponentValid = false;
				}
				//////////////
				$scope.inputemail = $("#inputemail").val();
   				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
   				if (!re.test($scope.inputemail)){
					result = {"valid" : false,
						"component" : "inputemail"};
					$scope.isInputemailValid = false;

				}
				else{
					result = {"valid" : true,
						"email" : $scope.inputemail,
						"component" : "inputemail"};
					$scope.isInputemailValid = true;
				}
   				$scope.childComponentValues.push(result);
   				if (result.valid != true){
					$scope.childComponentValid = false;
				}
				
			}

   			$scope.handleCreateIToldYoo = function(){
				$scope.childComponentValues = [];
				$scope.childComponentValid = true;
   				$scope.validateValues();
				$scope.$broadcast('itoldyoo-save-request');
   		
   			}

  			$scope.handleNewIToldYoo = function(value){
   				$scope.inputitoldyoo2 = value;
   				$scope.mode="creation";
  				  				
   			}

		},
		replace: true
	};
});

iToldYooComponents.directive('myitoldyoo', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
   		controller: function($rootScope, $scope, $http, itemRessource) {

	  	itemRessource.getItems()
		.success(function (data, status, headers, config) {
			if (data.code == 200){
				$scope.items = data.content;
            }
    	})
    	.error(function (data, status, headers, config) {
        	$scope.data = data;
        	$scope.status = status;
    	});
		},
		templateUrl: 'components/myitoldyoo.html',
		replace: true
	};
});

iToldYooComponents.directive('carrousel', function() {
    return {
		restrict: 'E',
		transclude: true,
		templateUrl: 'components/carrousel.html',
		replace: true,
		scope: { item : '=item'},
   		controller: function($scope) {

			$scope.myInterval = 3000;
			$scope.slides = [
			    {
			      image: 'http://lorempixel.com/400/200/'
			    },
			    {
			      image: 'http://lorempixel.com/400/200/food'
			    },
			    {
			      image: 'http://lorempixel.com/400/200/sports'
			    },
			    {
			      image: 'http://lorempixel.com/400/200/people'
			    }
		  	];

		}
	};
});
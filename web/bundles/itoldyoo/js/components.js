'use strict';

/* Components */

var iToldYooComponents = angular.module('iToldYooComponents', []);

iToldYooComponents.directive('whenpicker', function() {

	var componentName = "whenpicker";

    return {
		restrict: 'E',
		transclude: true,
		templateUrl: 'component/getTemplate/datetimepicker',
		scope: { 
				prompt:'@',
		},
		link: function(scope){
   			var result = {"component" : componentName};
   			scope.$emit('itoldyoo-loaded-response', result);		
		},
   		controller: function($rootScope, $scope, dateTimeHelper) {
   			$scope.finalDate = $scope.prompt;
   			$scope.template = "";
   			$scope.isOpen = false;

   			$scope.$on('itoldyoo-loaded-request', function(event, args) {
   				var result = {"component" : componentName};
			});

   			$scope.$on('itoldyoo-save-request', function(event, args) {
   				var result = $scope.validateValues();
   				$scope.$emit('itoldyoo-save-response', result);
			});

   			$scope.validateValues = function(){
				if ((typeof $scope.myDate == 'undefined') || ($scope.myDate == null)){
					var result = {"valid" : false,
						"component" : componentName};
					$scope.isValid = false;
					return result;	
				}
				else{
					var result = {"valid" : true,
						"date" : $scope.myDate,
						"component" : componentName};
					$scope.isValid = true;
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
	var componentName = "emailbox";

  	return {
    restrict: 'E',
    transclude: true,
    scope: {},
	link:function(scope,elem,attrs){
		scope.handleSelection=function(selectedItem){
			scope.addEmailList(scope.items[scope.current]);
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
					scope.addEmailList(scope.items[scope.current]);
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

		var result = {"component" : componentName};
		scope.$emit('itoldyoo-loaded-response', result);

	},
	controller: function($rootScope, $scope, $http, itemRessource){
				
		$scope.items = [];
		$scope.emailList = [];

		$scope.$on('itoldyoo-loaded-request', function(event, args) {
			var result = {"component" : componentName};
		});

		$scope.$on('itoldyoo-save-request', function(event, args) {
			var result = $scope.validateValues();
			$scope.$emit('itoldyoo-save-response', result);
		});

		$scope.validateValues = function(){
			if ((typeof $scope.emailList == 'undefined') || ($scope.emailList.length == 0)) {
				var result = {"valid" : false,
					"component" : componentName};
				$scope.isValid = false;
				return result;	
			}
			else{
				var result = {"valid" : true,
					"emails" : $scope.emailList,
					"component" : componentName};
				$scope.isValid = true;
				return result;

			}
		}

		$scope.filterEmails=function(keyPhrase, nbItems){
			$scope.items = [];
			if (!keyPhrase.length > 0) return;
			//first loop
			for(var i= 0; i < $scope.master.length; i++){
				if ($scope.items.length < nbItems){
					if ($scope.master[i].indexOf(keyPhrase) == 0){
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
						if ($scope.master[i].indexOf(keyPhrase) > 0){
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


	  	itemRessource.getEmails()
		.success(function (data, status, headers, config) {
			if (data.code == 200){
				$scope.master = angular.copy(data.emails);
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
    templateUrl: 'component/getTemplate/emailbox'
  }
});

iToldYooComponents.directive('itoldyooheader', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
		templateUrl: 'component/getTemplate/header',
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
		templateUrl: 'component/getTemplate/footer',
   		controller: function($scope) {
		},
		replace: true
	};
});

iToldYooComponents.directive('itoldyooemail', function() {
    
	var componentName = "itoldyooemail";

    return {
		restrict: 'E',
		transclude: true,
		scope: {},
		templateUrl: 'component/getTemplate/itoldyooemail',
		link: function(scope){
   			var result = {"component" : componentName};
   			scope.$emit('itoldyoo-loaded-response', result);		
		},
   		controller: function($scope, itemRessource) {

   			$scope.knownEmail = "";

			$scope.$on('itoldyoo-loaded-request', function(event, args) {
				var result = {"component" : componentName};
			});

			$scope.$on('itoldyoo-save-request', function(event, args) {
				var result = $scope.validateValues();
				$scope.$emit('itoldyoo-save-response', result);
			});

			$scope.validateValues = function(){
				$scope.inputemail = $("#inputemail").val();
				var result = null;
   				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
   				if (!re.test($scope.inputemail)){
					result = {"valid" : false,
						"component" : componentName};
					$scope.isValid = false;
				}
				else{
					result = {"valid" : true,
						"email" : $scope.inputemail,
						"component" : componentName};
					$scope.isValid = true;
				}
				return result;
			}

		  	itemRessource.getUserLastEmail()
			.success(function (data, status, headers, config) {
				if (data.code == 200){
					$scope.knownEmail = data.email;
	            }
	    	})
	    	.error(function (data, status, headers, config) {
	        	$scope.data = data;
	        	$scope.status = status;
	    	});
		},
		replace: true
	};
});

iToldYooComponents.directive('itoldyoomessage', function() {
    
	var componentName = "itoldyoomessage";

    return {
		restrict: 'E',
		transclude: true,
		scope: { message : '='},
		templateUrl: 'component/getTemplate/itoldyoomessage',
		link: function(scope){
   			var result = {"component" : componentName};
   			scope.$emit('itoldyoo-loaded-response', result);		
		},
   		controller: function($scope) {
   			var componentName = "itoldyoomessage";
			$scope.$on('itoldyoo-loaded-request', function(event, args) {
				var result = {"component" : componentName};
			});

			$scope.$on('itoldyoo-save-request', function(event, args) {
				var result = $scope.validateValues();
				$scope.$emit('itoldyoo-save-response', result);
			});

			$scope.validateValues = function(){
  				$scope.inputitoldyoo2 = $("#inputitoldyoo2").val();
				var result = null;
   				if ((typeof $scope.inputitoldyoo2 == 'undefined') || ($scope.inputitoldyoo2.length == 0)){
					result = {"valid" : false,
						"component" : componentName};
					$scope.isValid = false;
				}
				else{
					result = {"valid" : true,
						"message" : $scope.inputitoldyoo2,
						"component" : componentName};
					$scope.isValid = true;					

				}
				return result;
			}
		},
		replace: true
	};
});

iToldYooComponents.directive('itoldyoo', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
		templateUrl: 'component/getTemplate/itoldyoo',
		link: function(scope){
   			
		},
   		controller: function($scope, itemRessource) {
   			
   			//remote components
			$scope.$on('itoldyoo-loaded-response', function(event, args) {
				$scope.childComponents.push(args.component);
			});

			$scope.$on('itoldyoo-save-response', function(event, args) {
				
				$scope.childComponentValues.push(args);
				if (args.valid != true){
					$scope.childComponentValid = false;
				}
				if (($scope.childComponents.length == $scope.childComponentValues.length) && ($scope.childComponentValid == true)){
					//call server API to post
					
					var description = "";
					var scheduledDate = "";
					var email = "";
					var emails = [];
					for(var i= 0; i < $scope.childComponentValues.length; i++){
						if ($scope.childComponentValues[i].component == 'itoldyoomessage'){
							description =  $scope.childComponentValues[i].message;
						}
						else if ($scope.childComponentValues[i].component == 'itoldyooemail'){
							email =  $scope.childComponentValues[i].email;
						}
						else if ($scope.childComponentValues[i].component == 'emailbox'){
							emails = $scope.childComponentValues[i].emails;
						}
						else if ($scope.childComponentValues[i].component == 'whenpicker'){
							scheduledDate = $scope.childComponentValues[i].date.toUTCString();
						}

					}
					var tmp = {description:description, email:email,scheduledDate:scheduledDate,emails:emails };
					var finalJSON = JSON.stringify(tmp);
			   		itemRessource.createITolydoo(finalJSON)
					.success(function (data, status, headers, config) {
						if (data.code == 200){
							$scope.initModeView();
			            }
			            else{
			            	var message = {"message": data.message, "type":"warning"};
   							$scope.$broadcast('update-message-box', message);
			            }
			    	})
			    	.error(function (data, status, headers, config) {
			        	var message = {"message": "Error", "type":"danger"};
   						$scope.$broadcast('update-message-box', message);
			    	});
				}
				else if (($scope.childComponents.length == $scope.childComponentValues.length) && ($scope.childComponentValid == false)){
					var message = {"message": "Invalid value, please check your IToldYoo...", "type":"warning"};
   					$scope.$broadcast('update-message-box', message);

				}
			});

			$scope.initModeView = function(){
				$scope.childComponents = [];
				$scope.childComponentValues = [];
				$scope.childComponentValid = true;
				$scope.inputitoldyoo="";
				$scope.mode="view";
			}
			$scope.initModeCreation = function(){
				$scope.childComponents = [];
				$scope.childComponentValues = [];
				$scope.childComponentValid = true;
				$scope.mode="creation";

			}
   			$scope.handleCreateIToldYoo = function(){
				$scope.childComponentValues = [];
				$scope.childComponentValid = true;
				$scope.$broadcast('itoldyoo-save-request');
   			}

  			$scope.handleNewIToldYoo = function(value){
   				$scope.inputitoldyoo2 = value;
   				$scope.initModeCreation();
  			}
   			$scope.initModeView();

		},
		replace: true
	};
});

iToldYooComponents.directive('myitoldyoo', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
   		controller: function($scope,itemRessource) {

	  	itemRessource.getIToldyoo()
		.success(function (data, status, headers, config) {
			if (data.code == 200){
				$scope.items = data.content;
            }
    	})
    	.error(function (data, status, headers, config) {
        	var message = {"message": "Error", "type":"danger"};
			$scope.$broadcast('update-message-box', message);
    	});
		},
		templateUrl: 'component/getTemplate/myitoldyoo',
		replace: true
	};
});
iToldYooComponents.directive('messagebox', function() {
    return {
		restrict: 'E',
		transclude: true,
		scope: {},
   		controller: function($rootScope, $scope) {
   			$scope.type = "none";
   			$scope.$on('update-message-box', function(event, args) {
				$scope.type = args.type;
				$scope.message = args.message;
			});

		},
		templateUrl: 'component/getTemplate/messagebox',
		replace: true
	};
});

iToldYooComponents.directive('carrousel', function() {
    return {
		restrict: 'E',
		transclude: true,
		templateUrl: 'component/getTemplate/carrousel',
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
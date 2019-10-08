//home controller
app.controller("homeCtrl", function ($scope, $http) {
   	//get all user from database
   	$scope.getAllUsers = function(){
   		$http({
		    method : "GET",
		    url : "/user/get"
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.users = response.data.data;
		    }
		});
   	}
   	$scope.getAllUsers();
   	//get all logged inuser from database
   	$scope.getAllLoggedInUsers = function(){
   		$http({
		    method : "GET",
		    url : "/logged_in_user/getWith"
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.loggedInUsers = response.data.data;
		    }else{
		    	$scope.loggedInUsers = false;
		    }
		});
   	}
   	$scope.getAllLoggedInUsers();
   	//log user in 
   	$scope.logUserIn = function(){
   		$http({
		    method : "POST",
			url : "/logged_in_user/insert",
			headers: {
			  'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: {'user_id': $scope.selectedUser},
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.getAllLoggedInUsers();
		    }
		});
   	}
   	//log user in 
   	$scope.logUserOut = function(id){
   		$http({
		    method : "GET",
			url : "/logged_in_user/delete/" + id,
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.getAllLoggedInUsers();
		    }
		});
   	}
});
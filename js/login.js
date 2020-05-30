//login controller
app.controller("loginCtrl", function ($scope, $http, $rootScope, $window) {
   	$scope.doLogin = function(){
   		if($scope.loginForm != undefined && $scope.loginForm.username != undefined && $scope.loginForm.password != undefined){
	   		//login
			var req = {
			    method : "POST",
			    url : "/user/login",
			    headers: {
				   'Content-Type': 'application/x-www-form-urlencoded'
				},
				data: $scope.loginForm,
			};
			
			$http(req).then(function mySuccess(response) {
			    if(response.data.status){
			    	delete response.data.status;
			    	$rootScope.loggedInUser = response.data;
			    	var url = "http://" + $window.location.host + "/#!/home";
        			$window.location.href = url;
			    }else{
			    	swal({
		              	type: 'error',
		              	title: 'Kan niet inloggen',
		              	text: response.data.message,
		           	})
			    }
			});
		}else{
			swal({
              	type: 'error',
              	title: 'Kan niet inloggen',
              	text: 'Vul een geldig gebruikersnaam en wachtwoord in.',
           	})
		}
   	}
});
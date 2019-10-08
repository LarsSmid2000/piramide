//user controller
app.controller("userCtrl", function ($scope, $http) {
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

   	$scope.setInsertUser = function(){
   		$scope.userModalAction = 'insert';
   		$scope.insertForm = new Object();
   		//show modal
   		$('#userModal').modal('show');
   	}

	//get one user from database with id
   	$scope.getUser = function(id){
   		$scope.userModalAction = 'edit';
   		//find user in array
   		if($scope.users != undefined && id != undefined){
   			var users = $scope.users;

			var user = users.find(function(user) {
			  return user.id == id;
			});

			if(user != undefined){
				//set user in data array
				$scope.insertForm = user;
				//show modal
				$('#userModal').modal('show');
			}
   		}
   	}

   	//create and update user
	$scope.createPlayer = function(){
		console.log($scope.insertForm);
		//check for is for insert or update
		if($scope.insertForm.id != undefined){
			//update data
			var req = {
			    method : "POST",
			    url : "/user/update/" + $scope.insertForm.id,
			    headers: {
				   'Content-Type': 'application/x-www-form-urlencoded'
				},
				data: $scope.insertForm,
			};
		}else{
			//insert data
			var req = {
			    method : "POST",
			    url : "/user/insert",
			    headers: {
				   'Content-Type': 'application/x-www-form-urlencoded'
				},
				data: $scope.insertForm,
			};
		};
		
		$http(req).then(function mySuccess(response) {
		    if(response.data.status){
		    	//reload all users
				$scope.getAllUsers();
				//hide modal
				$('#userModal').modal('hide');
		    }
		});
	}

	//delete user
	$scope.deleteUser = function(id){
		var req = {
		    method : "POST",
		    url : "/user/delete/" + id,
		    headers: {
			   'Content-Type': 'application/x-www-form-urlencoded'
			},
		};
		$http(req).then(function mySuccess(response) {
		    if(response.data.status){
		    	//reload all users
				$scope.getAllUsers();
		    }
		});
	}
});
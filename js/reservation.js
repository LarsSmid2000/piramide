//user controller
app.controller("reservationCtrl", function ($scope, $http) {
   	//get all user from database
   	$scope.getAllReservations = function(){
   		$http({
		    method : "GET",
		     url : "/user/getreservations"
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.reservations = response.data.data;
				$scope.selectedReservations = response.data.data;
		    }
		});
   	}
   	$scope.getAllReservations();

   	$scope.searchReservations = function() {
   		$scope.selectedReservations = [];
   		var reservations = $scope.reservations;
   		var searchField = "";
   		
   		reservations.forEach(reservation => {
   			searchField = JSON.stringify(reservation.name + reservation.email + reservation.datetime + JSON.stringify(reservation.persons));
   			
   			if (searchField.search($scope.search) != undefined && searchField.search($scope.search) != -1) {
   				$scope.selectedReservations.push(reservation);
   			}
   		});
   	}

   	$scope.setInsertReservation = function(){
   		$scope.reservationModalAction = 'insert';
   		$scope.insertForm = new Object();
   		//show modal
   		$('#reservationModal').modal('show');
   	}

	//get one user from database with id
   	$scope.getReservation = function(id){
   		$scope.reservationModalAction = 'edit';
   		//find user in array
   		if($scope.reservations != undefined && id != undefined){
   			var reservations = $scope.reservations;

			var reservation = reservations.find(function(reservation) {
			  return reservation.id == id;
			});

			if(reservation != undefined){
				//set reservation in data array
				if (reservation.max_places) {
					reservation.max_places = parseInt(reservation.max_places);
				}
				if (reservation.date) {
					reservation.date = new Date(Date.parse(reservation.date));
				}
				$scope.insertForm = reservation;
				//show modal
				$('#reservationModal').modal('show');
			}
   		}
   	}

   	//create and update user
	$scope.createReservation = function(){
		//check for is for insert or update
		if($scope.insertForm.id != undefined){
			//update data
			var req = {
			    method : "POST",
			    url : "/user/updateReservation/" + $scope.insertForm.id,
			    headers: {
				   'Content-Type': 'application/x-www-form-urlencoded'
				},
				data: $scope.insertForm,
			};
		}else{
			//insert data
			var req = {
			    method : "POST",
			    url : "/user/insertReservation",
			    headers: {
				   'Content-Type': 'application/x-www-form-urlencoded'
				},
				data: $scope.insertForm,
			};
		};
		
		$http(req).then(function mySuccess(response) {
		    if(response.data.status){
		    	//reload all users
				$scope.getAllReservations();

				swal({
	              	type: 'success',
	              	title: 'Reservering succesvol ' + ($scope.insertForm.id != undefined ? 'bewerkt' : 'aangemaakt'),
	              	text: response.data.message,
	           	})
				//hide modal
				$('#reservationModal').modal('hide');
		    } else {
		    	swal({
	              	type: 'error',
	              	title: 'Er is iet fout gegaan.',
	              	text: response.data.message,
	           	})
		    }
		});
	}

	//delete user
	$scope.deleteReservation = function(id){
		var req = {
		    method : "POST",
		    url : "/user/deleteReservation/" + id,
		    headers: {
			   'Content-Type': 'application/x-www-form-urlencoded'
			},
		};
		$http(req).then(function mySuccess(response) {
		    if(response.data.status){
		    	//reload all users
				$scope.getAllReservations();
				swal({
	              	type: 'success',
	              	title: 'Reservering succesvol verwijderd',
	              	text: response.data.message,
	           	})
		    } else {
		    	swal({
	              	type: 'error',
	              	title: 'Er is iets fout gegaan',
	              	text: response.data.message,
	           	})
		    }
		});
	}

	$scope.getReservationTypes = function() {
		$http({
		    method : "GET",
		     url : "/user/getreservationtypes"
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.reservationTypes = response.data.data;
		    }
		});
	}
	$scope.getReservationTypes();

	$scope.getReservationPersons = function(reservation) {
		$scope.selectedReservation = reservation;

		$('#reservationPersonsModal').modal('show');
	}

	$scope.deletePerson = function(reservationId, person) {
		var req = {
		    method : "POST",
		    url : "/user/deleteReservationPerson/" + reservationId,
		    headers: {
			   'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: {"person": person},
		};
		$http(req).then(function mySuccess(response) {
		    if(response.data.status){
		    	//reload all users
				$scope.getAllReservations();
				$('#reservationPersonsModal').modal('hide');
				swal({
	              	type: 'success',
	              	title: 'Persoon succesvol verwijderd',
	              	text: response.data.message,
	           	})
		    } else {
		    	swal({
	              	type: 'error',
	              	title: 'Er is iets fout gegaan',
	              	text: response.data.message,
	           	})
		    }
		});
	}
});
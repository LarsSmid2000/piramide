//home controller
app.controller("homeCtrl", function ($scope, $http) {
	/**
	  * Variables
	 **/
   	$scope.days = [];
   	$scope.dayTimes = [];
   	$scope.selectedReservation = [];
   	$scope.username = '';
   	$scope.email = '';
   	$scope.currentWeek = 1;
   	$scope.messages = {
   		"insert.person.failed": "Er is iets fout gegaan",
   		"invalid.person.reservation": "Er is iets fout gegaan",
   		"reservation.is.full": "Helaas, de  training zit vol",
   		"no.reservation.failed": "Er is iets fout gegaan",
   		"missing.user.values": "Er is iets fout gegaan",
   		"no.reservation.failed": "Er is iets fout gegaan",
   		"missing.reservation.id": "Er is iets fout gegaan",
   		"already.signedup.person": "Deze persoon is al aangemeld",
   		"already.reserved.failed": "Dit tijd blok op dit veld is helaas al gereserveerd",
   		"no.persons.failed": "Vul minimaal 1 persoon in",
   		"no.email.failed": "Vul een emailadres in",
   		"no.name.failed": "Vul een groeps naam in",
   		"update.reservation.failed": "Er is iets fout gegaan",
   		"no.id.failed": "Er is iets fout gegaan",
   	};

   	/**
	  * Functions
	 **/
   	//get all days from database
   	$scope.getAllDays = function(){
   		$http({
		    method : "GET",
		    url : "/day/get"
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.days = response.data.data;
				$scope.getAllDayTimes();
		    }
		});
   	}
   	$scope.getAllDays();

   	//get all day times from database
   	$scope.getAllDayTimes = function(){
   		$http({
		    method : "GET",
		    url : "/day_time/gettimeswithdate"
		}).then(function mySuccess(response) {
		    if(response.data.status){
				$scope.dayTimes = response.data.data;
		    }
		});
   	}

   	$scope.createPersonArr = function() {
	    $scope.arrPersons = new Array();
	    if ($scope.amountOfPersons != undefined && $scope.amountOfPersons > 0) {
	    	
	    	for (var i = 0; i < $scope.amountOfPersons; i++) {
	    		$scope.arrPersons.push(i + 1);
	    	}
	    }
	}

   	$scope.checkReservation = function() {
	    if ( $scope.amountOfPersons == undefined || $scope.amountOfPersons == 0 || $scope.amountOfPersons > 8 ) {
	    	return true
	    }

	    return false;
	}

   	$scope.checkFilledName = function() {
	    if ( ($scope.username == undefined || $scope.username == '' || $scope.email == undefined || $scope.email == '') ) {
	    	return true;
	    }

	    return false;
	}

	$scope.checkFilledReservation = function() {
	    if ( ($scope.newReservation.name == undefined || $scope.newReservation.name == '' || $scope.newReservation.email == undefined || $scope.newReservation.email == '') ) {
	    	return true;
	    }

	    return false;
	}

	$scope.openReservationModal = function(selectedDateTime, field) {
		//set selected reservation
		$scope.selectedReservation = {};
		$scope.selectedReservation = selectedDateTime;

		//open modal
		$('#reservationModal').modal('show')
	}

	$scope.createNewReservation = function(selectedDateTime, field) {
		//set selected reservation
		$scope.newReservation = {};
		$scope.newReservation = selectedDateTime;
		$scope.selectedReservation = {};
		$scope.selectedReservation = selectedDateTime;

		//open modal
		$('#reservationModal').modal('show')
	}

	$scope.reserve = function() {
		if (!document.getElementById('email').validity.valid) {
			return false;
		}
		$http({
		    method : "POST",
		    url : "/reservation/reserveDateTime/" + $scope.newReservation.reservation.id,
		    data: $scope.newReservation,
		}).then(function mySuccess(response) {
		    if(response.data.status){
				swal({
	              	type: 'success',
	              	title: 'Je hebt gereserveerd',
	              	text: 'Je zal een bevestiging krijgen op het ingevulde emailadres',
	           	})
	           	$scope.getAllDayTimes();
		    } else {
		    	swal({
	              	type: 'error',
	              	title: $scope.messages[response.data.message],
	           	})
		    }
		});

		//open modal
		$('#reservationModal').modal('hide')
	}

	$scope.signUpForTraining = function(reservationId) {
		if (!document.getElementById('email_reservation').validity.valid) {
			return false;
		}
		$http({
		    method : "POST",
		    url : "/reservation/signUpForTraining/" + reservationId,
		    data: {'name': $scope.username, 'email': $scope.email}
		}).then(function mySuccess(response) {
		    if(response.data.status){
				swal({
	              	type: 'success',
	              	title: 'Je bent aangemeld',
	           	})
		    } else {
		    	swal({
	              	type: 'error',
	              	title: $scope.messages[response.data.message],
	           	})
		    }
		});

		//open modal
		$('#reservationModal').modal('hide')
	}
});
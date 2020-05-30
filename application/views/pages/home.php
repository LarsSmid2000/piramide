<div class="container-fluid mt-4">
	<div class="row mb-3">
		<div class="col-md-6">
			<button type="button" class="btn btn-success w-100" ng-disabled="currentWeek == 1" ng-click="currentWeek = 1">Huidige week</button>
		</div>
		<div class="col-md-6">
			<button type="button" class="btn btn-success w-100" ng-disabled="currentWeek == 2" ng-click="currentWeek = 2">Volgende week</button>
		</div>
	</div>
	<div class="row" ng-repeat="day in days" ng-show="day.week == currentWeek">
		<div class="col-md-12">
			<div class="card mb-4">
				<div class="card-header">
					<p class="card-title m-0"><b>{{day.name}}</b> {{day.date}}</p>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6" ng-repeat="field in ['1', '2']">
							<b>Veld {{field}}</b>
							<div class="row time-row {{}}" ng-class="field == 1 ? 'time-row-border-right' : ''" ng-repeat="time in dayTimes[day.date + field]">
								<div class="col-6 col-md-6">
									{{time.start_time}} - {{time.end_time}} {{time.reservation.name ? '-' : ''}} <b>{{time.reservation.name}}</b>
									<br>
									<i>{{ time.reservation.reservation_type_id == 1 && time.reservation.reserved == 1 ? 'Gereserveerd' : '' }}
									{{time.reservation.description}}</i>
									<br><br>
									<b>{{time.reservation.responsible && time.reservation.responsible.length ? 'Kaderlid:' : ''}}</b> {{time.reservation.responsible}}
															</div>
								<div class="col-6 col-md-6" ng-if="time.reservation && time.reservation.reservation_type_id == 2">
									<button type="button" class="btn btn-primary" ng-click="openReservationModal(time, field)" ng-if="time.reservation.taken_places != time.reservation.max_places">Aanmelden</button>
									<button type="button" class="btn btn-primary" ng-if="time.reservation.taken_places == time.reservation.max_places" ng-disabled="true">De trainging zit vol</button>
								</div>
								<!--
								<div class="col-6 col-md-6" ng-if="time.reservation == undefined">
									<button type="button" class="btn btn-primary" ng-click="createNewReservation(time, field)">Reserveer</button>
								</div>
								-->
								<div class="col-6 col-md-6" ng-if="time.reservation && time.reservation.reservation_type_id == 1 && time.reservation.reserved == 0">
									<button type="button" class="btn btn-info" ng-click="createNewReservation(time, field)">Reserveer</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<h5 class="modal-title" id="exampleModalLabel">{{selectedReservation.reservation.reservation_type_id == 1 ? 'Reserveer veld '  + selectedReservation.field : 'Meld je aan voor ' + selectedReservation.reservation.name }}</h5>
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		         		<span aria-hidden="true">&times;</span>
		        	</button>
		      	</div>
		      	<!-- hire field 
		      	<div class="modal-body" ng-show="newReservation">-->
		      	<div class="modal-body" ng-show="selectedReservation.reservation && selectedReservation.reservation.reservation_type_id == 1">
		        	<!-- Reservation form -->
		        	<div class="form-group">
					    <label for="name">Groepsnaam</label>
					    <input type="text" class="form-control" id="name" placeholder="Vul een naam in voor de reservering" ng-model="newReservation.name">
					</div>
					<div class="form-group">
					    <label for="email">E-mailadres hoofdboeker</label>
					    <input type="email" class="form-control" id="email_reservation" placeholder="Vul een emailadres is" ng-model="newReservation.email">
					</div>
		        	<div class="form-group">
					    <label for="amount_persons">Aantal personen</label>
					    <input type="number" min="1" max="6" class="form-control" id="amount_persons" placeholder="Vul het aantal personen in" ng-model="amountOfPersons" ng-change="createPersonArr()">
					    <small class="text-muted">Maximaal 6 personen</small>
					</div>
					<!-- if amount of persons is filled -->
					<div class="form-group" ng-repeat="personNumber in arrPersons">
					    <label for="person_{{personNumber}}">Persoon {{personNumber}} {{personNumber == 1 ? '(Hoofdboeker)' : ''}}</label>
					    <input type="text" class="form-control" id="person_{{personNumber}}" placeholder="Vul een naam in" ng-model="newReservation.persons[personNumber]">
					</div>
		     	</div>
		     	<!-- training -->
		     	<div class="modal-body" ng-show="selectedReservation.reservation && selectedReservation.reservation.reservation_type_id == 2">
		        	<p>Vul je naam in en klik op aanmelden. Heb je je al aangemeld? Dan hoef dit niet nog een keer</p>
					<!-- name -->
					<div class="form-group">
					    <label for="name">Naam</label>
					    <input type="text" class="form-control" id="name" placeholder="Vul je naam in" ng-model="username">
					</div>
					<!-- email -->
					<div class="form-group">
					    <label for="email">Email</label>
					    <input type="email" class="form-control" id="email" placeholder="Vul je naam in" ng-model="email" aria-describedby="emailHelp">
					     <small id="emailHelp" class="form-text text-muted">Vul een geldig email adres in om door te gaan</small>
					</div>
		     	</div>
		     	<div class="modal-footer">
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
		        	<!-- training button -->
		        	<button type="button" class="btn btn-primary" ng-disabled="checkFilledName()" ng-if="selectedReservation.reservation && selectedReservation.reservation.reservation_type_id == 2" ng-click="signUpForTraining(selectedReservation.reservation.id)">Meld je aan</button>
		        	<!-- Reservation button old
		        	<button type="button" class="btn btn-primary" ng-disabled="checkFilledReservation()" ng-if="newReservation" ng-click="reserve()">Reserveer</button>-->

		        	<button type="button" class="btn btn-primary" ng-disabled="checkFilledReservation()" ng-if="selectedReservation.reservation && selectedReservation.reservation.reservation_type_id == 1" ng-click="reserve()">Reserveer</button>
		     	</div>
		    </div>
		</div>
	</div>
</div>
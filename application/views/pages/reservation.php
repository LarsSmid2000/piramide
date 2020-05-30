<div class="container-fluid  mt-4">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-7">
							<h5 class="card-title">Alle reserveringen	</h5>
							<h6 class="card-subtitle mb-2 text-muted">Maak of bewerk een reserveringen</h6>
						</div>
						<div class="col-md-5 text-right">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
								    	<input type="text" class="form-control" placeholder="Zoeken" id="search" ng-model="search" ng-change="searchReservations()">
								  	</div>	
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#reservationModal" ng-click="setInsertReservation()">
									  	<i class="fas fa-plus"></i> Nieuwe reserveringen
									</button>
								</div>
							</div>
						</div>

					</div>
					
					<div class="table-responsive">
						<table class="table table-striped">
						  	<thead>
						    	<tr>
						      		<th scope="col">#</th>
						      		<th scope="col">Naam</th>
						      		<th scope="col">Beschrijving</th>
						      		<th scope="col">Kaderlid</th>
						      		<th scope="col">Type</th>
						      		<th scope="col">Datum en tijd</th>
						      		<th scope="col">Max aantal personen</th>
						      		<th scope="col">Gereserveerd</th>
						      		<th scope="col">Aangemelde personen</th>
						      		<th scope="col"></th>
						    	</tr>
						  	</thead>
						  	<tbody>
						    	<tr ng-repeat="reservation in selectedReservations track by $index">
						      		<td>{{$index + 1}}</td>
						      		<td>{{reservation.name}}</td>
						      		<td>{{reservation.description}}</td>
						      		<td>{{reservation.responsible}}</td>
						      		<td>{{reservationTypes[reservation.reservation_type_id]['name']}}</td>
						      		<td>{{reservation.datetime}}</td>
						      		<td>{{reservation.max_places}}</td>
						      		<td>
						      			<i ng-if="reservation.reserved == 1 " class="fas fa-check text-success"></i>
						      			<i ng-if="reservation.reserved == 0 " class="fas fa-times text-danger"></i>
						      		</td>
						      		<td>
							      		<ul>
							      			<li ng-repeat="person in reservation.persons">
							      				{{person.name}}, {{person.email}}
							      			</li>
							      		</ul>
						      		</td>
						      		<td class="text-right" >
						      			<button type="button" class="btn btn-sm btn-secondary mb-2" ng-click="getReservationPersons(reservation)"><i class="fas fa-users"></i> Bewerk aangemelde personen</button>
						      			<button type="button" class="btn btn-sm btn-warning mb-2" ng-click="getReservation(reservation.id)"><i class="fas fa-pencil-alt"></i> Bewerk</button>
						        		<button type="button" class="btn btn-sm btn-danger mb-2" ng-click="deleteReservation(reservation.id)"><i class="fas fa-trash"></i> Verwijder</button>
						      		</td>
						   		</tr>
						  	</tbody>
						</table>
					</div>
					<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  						<div class="modal-dialog" role="document">
					   		<div class="modal-content">
					     	 	<div class="modal-header">
					        		<h5 class="modal-title">{{ reservationModalAction == 'insert' ? 'Maak een reservering aan' : 'Bewerk een reservering'}}</h5>
					        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          			<span aria-hidden="true">&times;</span>
					        		</button>
					      		</div>
					      		<div class="modal-body">
					      			<form ng-submit="createReservation()">
					      				<div class="form-group">
										    <label for="type">Type</label>
										    <select class="form-control" id="type" ng-model="insertForm.reservation_type_id">
										      	<option value="1">Reservering</option>
										      	<option value="2">Training</option>
										    </select>
										</div>
					      				<div class="form-group" ng-if="insertForm.reservation_type_id == 2">
									    	<label for="name">Naam</label>
									    	<input type="text" class="form-control" id="name"  ng-model="insertForm.name">
									  	</div>
									  	<div class="form-group" ng-if="insertForm.reservation_type_id == 2">
									    	<label for="description">Beschrijving </label>
									    	<textarea type="text" class="form-control" id="description"  ng-model="insertForm.description"></textarea>
									  	</div>
									  	<div class="form-group">
									    	<label for="responsible">Kaderlid</label>
									    	<input type="text" class="form-control" id="responsible"  ng-model="insertForm.responsible" >
									  	</div>
										<div class="form-group" ng-if="insertForm.reservation_type_id == 2">
									    	<label for="max_places">Maximaal aantaal personen</label>
									    	<input type="number" class="form-control" id="max_places"  ng-model="insertForm.max_places">
									  	</div>
									  	<div class="form-group">
									    	<label for="name">Veld</label>
									    	<select class="form-control" id="type" ng-model="insertForm.field">
										      	<option value="1">Veld 1</option>
										      	<option value="2">Veld 2</option>
										    </select>
									  	</div>
					        			<div class="form-group">
									    	<label for="date">Datum</label>
									    	<input type="date" class="form-control" id="date" placeholder="Achternaam" ng-model="insertForm.date">
									  	</div>
									  	<div class="form-group">
										    <label for="time">Tijd</label>
										    <select class="form-control" id="time" ng-model="insertForm.time">
										      	<option value="17:00:00">17:00 - 18:00</option>
										      	<option value="17:15:00">17:15 - 18:15</option>
										      	<option value="17:45:00">17:45 - 18:45</option>
										      	<option value="18:15:00">18:15 - 19:15</option>
										      	<option value="18:30:00">18:30 - 19:30</option>
										      	<option value="18:30:00">18:30 - 20:00</option>
										      	<option value="19:00:00">19:00 - 20:30</option>
										      	<option value="19:30:00">19:30 - 20:30</option>
										      	<option value="19:30:00">19:30 - 21:00</option>
										      	<option value="20:00:00">20:00 - 21:30</option>
										      	<option value="20:30:00">20:30 - 22:00</option>
										    </select>
										</div>
									  	<div class="row">
									  		<div class="col-md-12 text-right">
										  		<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
						        				<button type="submit" class="btn btn-primary">{{ reservationModalAction == 'insert' ? 'Maak' : 'Bewerk'}}</button>
									  		</div>
									  	</div>								
					        		</form>
								</div>
					    	</div>
					  	</div>
					</div>
					<!-- Modal -->
					<div class="modal fade" id="reservationPersonsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Bewerk aanmeldingen - {{selectedReservation.name}}</h5>
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						         		<span aria-hidden="true">&times;</span>
						        	</button>
						      	</div>
						      	<!-- hire field -->
						     	<div class="modal-body" >
						        	<p>Klik op kruisje om een aangemeld persoon te verwijderen</p>
						        	<ul>
						        		<li ng-repeat="person in selectedReservation.persons">{{person.name}}, {{person.email}} <span class="text-danger pointer" ng-click="deletePerson(selectedReservation.id, person)">X</span></li>
						        	</ul>
									
						     	</div>
						     	<div class="modal-footer">
						        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit aangemelde personen</button>
						     	</div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="container-fluid  mt-4">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-9">
							<h5 class="card-title">Alle spelers	</h5>
							<h6 class="card-subtitle mb-2 text-muted">Maak of bewerk een speler</h6>
						</div>
						<div class="col-md-3 text-right">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal" ng-click="setInsertUser()">
							  	Nieuwe speler
							</button>
						</div>

					</div>
					
					<div class="table-responsive">
						<table class="table table-striped">
						  	<thead>
						    	<tr>
						      		<th scope="col">Voornaam</th>
						      		<th scope="col">Achternaam</th>
						      		<th scope="col">Spelersnaam</th>
						      		<th scope="col"></th>
						    	</tr>
						  	</thead>
						  	<tbody>
						    	<tr ng-repeat="user in users">
						      		<td>{{user.firstname}}</td>
						      		<td>{{user.lastname}}</td>
						      		<td>{{user.player_name}}</td>
						      		<td class="text-right" >
						      			<button type="button" class="btn btn-sm btn-secondary" ng-click="getUser(user.id)">Bewerk</button>
						        		<button type="button" class="btn btn-sm btn-danger" ng-click="deleteUser(user.id)">Verwijder</button>
						      		</td>
						   		</tr>
						  	</tbody>
						</table>
					</div>
					<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  						<div class="modal-dialog" role="document">
					   		<div class="modal-content">
					     	 	<div class="modal-header">
					        		<h5 class="modal-title">{{ userModalAction == 'insert' ? 'Maak een speler aan' : 'Bewerk een speler'}}</h5>
					        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          			<span aria-hidden="true">&times;</span>
					        		</button>
					      		</div>
					      		<div class="modal-body">
					      			<form ng-submit="createPlayer()">
					      				<div class="form-group">
									    	<label for="firstname">Voornaam</label>
									    	<input type="text" class="form-control" id="firstname" placeholder="Voornaam" ng-model="insertForm.firstname" required="">
									  	</div>
					        			<div class="form-group">
									    	<label for="lastname">Achternaam</label>
									    	<input type="text" class="form-control" id="lastname" placeholder="Achternaam" ng-model="insertForm.lastname">
									  	</div>
									  	<div class="form-group">
									    	<label for="player_name">Spelersnaam</label>
									    	<input type="text" class="form-control" id="player_name" aria-describedby="playerTekst" placeholder="Spelersnaam" ng-model="insertForm.player_name" required="">
									    	<small id="playerTekst" class="form-text text-muted">Dit is de naam waarmee je inlogt en speelt.</small>
									  	</div>
									  	<div class="row">
									  		<div class="col-md-12 text-right">
										  		<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
						        				<button type="submit" class="btn btn-primary">{{ userModalAction == 'insert' ? 'Maak' : 'Bewerk'}}</button>
									  		</div>
									  	</div>								
					        		</form>
								</div>
					    	</div>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
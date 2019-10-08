<div class="container-fluid  mt-4">
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<h5 class="card-title">Meld je aan	</h5>
							<h6 class="card-subtitle mb-2 text-muted">Meld je aan met je spelersnaam</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" ng-init="selectedUser = 'false'">
							 <div class="form-group">
							    <select class="form-control" id="loginUser" ng-model="selectedUser">
							      <option value="false">Select</option>
							      <option ng-repeat="user in users" value="{{user.id}}">{{user.player_name}}</option>
							    </select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							 <button type="button" class="btn btn-primary pull-right" ng-disabled="selectedUser == 'false'" ng-click="logUserIn()">Aanmelden</button>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md-12">
							<h5 class="card-title">Aangemeld</h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<ul class="list-group">
								<li class="list-group-item" ng-if="loggedInUsers == false">Geen spelers aangemeld</li>
							  	<li class="list-group-item" ng-repeat="loggedInUser in loggedInUsers">
							  		{{loggedInUser.user.player_name}}
							  		<span class="badge text-danger pull-right pointer" ng-click="logUserOut(loggedInUser.id)">X</span>
							  	</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<h5 class="card-title">Wedstrijd 1</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<ul class="list-group">
										<li class="list-group-item">
											Sam
										</li>
									  	<li class="list-group-item">
									  		Lars
									  	</li>
									</ul>
								</div>
								<div class="col-md-2">
									<p class="text-center text-lg mt-3" style="font-size:40px;"><i class="fas fa-times"></i></p>
								</div>
								<div class="col-md-4">
									<ul class="list-group">
										<li class="list-group-item">
											Sam
										</li>
									  	<li class="list-group-item">
									  		Lars
									  	</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 mt-3">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<h5 class="card-title">Wedstrijd 2</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<ul class="list-group">
										<li class="list-group-item">
											Sam
										</li>
									  	<li class="list-group-item">
									  		Lars
									  	</li>
									</ul>
								</div>
								<div class="col-md-2 text-center">
									<p style="font-size:40px;"><i class="fas fa-times"></i></p>
								</div>
								<div class="col-md-4">
									<ul class="list-group">
										<li class="list-group-item">
											Sam
										</li>
									  	<li class="list-group-item">
									  		Lars
									  	</li>
									</ul>
								</div>
								<div class="col-md-2 text-center">
									<button type="button" class="btn btn-success mt-3">Resultaat</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

	</div>
</div>
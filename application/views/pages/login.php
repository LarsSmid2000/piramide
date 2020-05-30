<div class="container-fluid">
	<div class="row" style="margin-top: 15vh">
		<div class="col-sm-12 col-md-6 offset-md-3">
			<div class="row">
				<div class="col-12 bg-white pl-0 rounded-right border-top border-right border-bottom">
					<div class="row">
						<div class="col-md-12">
							<h5 class="card-title pt-3 px-3">Login</h5>
    						<h6 class="card-subtitle mb-2 text-muted px-3">Dit is het betaal systeem van vollido. Login voor het beheer van de digitale lijst.</h6>
							<form class="pl-3 pt-3">
							  	<div class="form-group">
							    	<label for="username">Gebruikersnaam</label>
							   	 	<input type="text" class="form-control" id="username" placeholder="Vul gebruikersnaam in" ng-model="loginForm.username">
							  	</div>
							  	<div class="form-group">
							    	<label for="password">Password</label>
							    	<input type="password" class="form-control" id="password" placeholder="Vul wachtwoord in" ng-model="loginForm.password">
							 	</div>
							  	<button type="button" class="btn btn-primary float-right mb-2" ng-click="doLogin()">Login</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
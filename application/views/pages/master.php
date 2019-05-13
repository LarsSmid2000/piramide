<!DOCTYPE html>
<html>
<head>
	<title>Backoffice</title>
	<!-------[Bootstap style]-------->
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<!-------[Bootstap javascript]-------->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/js/bootstrap.js"></script>
	<!-------[Angular JS]------->
	<script type="text/javascript" src="/js/angular.js"></script>
	<script type="text/javascript" src="/js/angular-route.js"></script>
	<script type="text/javascript" src="/js/script.js"></script>
</head>

<body ng-app="myApp" ng-controller="masterCtrl">
  <div ng-if="user">
    <!------[NAVBAR]------>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#!home" data-toggle="collapse" data-target="#navbarNavDropdown">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#!user" data-toggle="collapse" data-target="#navbarNavDropdown">User</a>
          </li></div>
        </ul>
      </div>
    </nav>
    <div ng-if="user" ng-view ></div>
  </div>
  <!----- LOGIN ------>
  <div ng-if="!user">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-3">
          <form class="form-signin" ng-submit="doLogin(loginData)">
            <h2 class="form-signin-heading">Please sign in</h2>
              <label for="inputEmail" class="sr-only">Email address</label>
              <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="" ng-model="loginData.username">
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" ng-model="loginData.password">
              <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Sign in</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
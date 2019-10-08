<!DOCTYPE html>
<html>
<head>
	<title>Piramide</title>
	<!-------[Bootstap style]-------->
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<!-------[Bootstap javascript]-------->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/js/bootstrap.js"></script>
	<!-------[Angular JS]------->
	<script type="text/javascript" src="/js/angular.js"></script>
	<script type="text/javascript" src="/js/angular-route.js"></script>

  <!-------[Font awesome]------->
  <script src="https://kit.fontawesome.com/eab76416a5.js" crossorigin="anonymous"></script>
	
  <!-------[Own JS]------->
  <script type="text/javascript" src="/js/script.js"></script>
  <script type="text/javascript" src="/js/user.js"></script>
  <script type="text/javascript" src="/js/home.js"></script>
</head>

<body ng-app="myApp" ng-controller="masterCtrl">
  <div>
    <!------[NAVBAR]------>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Vollido</a>
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
    <div ng-view ></div>
  </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>Beachen | Vollido</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-------[Bootstap style]-------->
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<!-------[Bootstap javascript]-------->
	<script type="text/javascript" src="/js/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="/js/bootstrap.js"></script>
	<!-------[Angular JS]------->
	<script type="text/javascript" src="/js/angular.js"></script>
	<script type="text/javascript" src="/js/angular-route.js"></script>

  <!-------[Font awesome]------->
  <script type="text/javascript" src="/js/fontawesome.js"></script>
	
  <!-------[Sweetalert]------->
  <script type="text/javascript" src="/js/sweetalert2.min.js"></script>

  <!-------[Own JS]------->
  <script type="text/javascript" src="/js/script.js"></script>
  <script type="text/javascript" src="/js/user.js"></script>
  <script type="text/javascript" src="/js/home.js"></script>
  <script type="text/javascript" src="/js/login.js"></script>
  <script type="text/javascript" src="/js/reservation.js"></script>
  <script type="text/javascript" src="/js/instruction.js"></script>
  <script type="text/javascript" src="/js/protocols.js"></script>
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
            <a class="nav-link" href="#!home" data-toggle="collapse" data-target="#navbarNavDropdown">Home</a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="#!aanmelden" data-toggle="collapse" data-target="#navbarNavDropdown">Aanmelden </a>
          </li>  
          <li class="nav-item">
            <a class="nav-link" href="#!protocollen" data-toggle="collapse" data-target="#navbarNavDropdown">Protocollen</a>
          </li> 
          <li class="nav-item" ng-if="loggedInUser">
            <a class="nav-link" href="#!reservering" data-toggle="collapse" data-target="#navbarNavDropdown">Reserveringen</a>
          </li>
          <li class="nav-item" ng-if="!loggedInUser">
            <a class="nav-link" href="#!login" data-toggle="collapse" data-target="#navbarNavDropdown">Admin</a>
          </li>
        </ul>
      </div>
        <div class="mr-2" ng-show="loggedInUser">
          <a class="btn btn-secondary ng-binding text-white">
            {{loggedInUser.firstname}} {{loggedInUser.lastname}}
          </a>
        </div>
        <ul class="navbar-nav flex-row mr-lg-0" ng-if="loggedInUser">
          <li class="nav-item">
            <a class="btn btn-danger text-white" ng-click="doLogout()">Log uit</a>
          </li>
        </ul>
      </div>
    </nav>
    <div ng-view ></div>
  </div>
</body>
</html>
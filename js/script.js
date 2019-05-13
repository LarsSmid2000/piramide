var app = angular.module("myApp", ["ngRoute"]);

app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "/page/view/home",
    })
    .when("/home", {
        templateUrl : "/page/view/home",
    })
    .when("/user", {
        templateUrl : "/page/view/user",
        controller : "userCtrl"
    });
});

//master controller
app.controller("masterCtrl", function ($scope) {
    $scope.doLogin = function(data){
        console.log("do login");
        console.log(data);
   }
});

//home controller
app.controller("homeCtrl", function ($scope, $http) {
    $http({
        method : "GET",
        url : "user/getUsers"
    }).then(function mySuccess(response) {
        console.log(response);
    }, function myError(response) {
        //error
    });
});

//user controller
app.controller("userCtrl", function ($scope) {
   
});

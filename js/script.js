var app = angular.module("myApp", ["ngRoute"]);

app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "/page/view/home",
    })
    .when("/home", {
        templateUrl : "/page/view/home",
        controller : "homeCtrl"
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

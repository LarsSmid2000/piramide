var app = angular.module("myApp", ["ngRoute"]);

app.config(function($routeProvider) {
    $routeProvider
    .when("/#!/", {
        redirectTo: '/home'
    })
    .when("/aanmelden", {
        templateUrl : "/page/view/home",
        controller : "homeCtrl"
    })
    .when("/login", {
        templateUrl : "/page/view/login",
        controller : "loginCtrl"
    })
    .when("/reservering", {
        templateUrl : "/page/view/reservation",
        controller : "reservationCtrl"
    }) 
    .when("/home", {
        templateUrl : "/page/view/instruction",
        controller : "instructionCtrl"
    })
    .when("/protocollen", {
        templateUrl : "/page/view/protocols",
        controller : "protocolsCtrl"
    })
    .otherwise({
        redirectTo: '/home'
    });
});

//master controller
app.controller("masterCtrl", function ($scope, $http, $rootScope, $window) {
    $scope.checkForUser = function(){
        $http({
            method : "GET",
             url : "/user/getSession"
        }).then(function mySuccess(response) {
            if(response.data.status){
                $rootScope.loggedInUser = response.data.data;
            }else{
                //not loggedIn
            }
        });
    }
    $scope.checkForUser();

    $scope.doLogout = function(){
        $http({
            method : "GET",
             url : "/user/logout"
        }).then(function mySuccess(response) {
            if(response.data.status){
                $rootScope.loggedInUser = false;
                var url = "http://" + $window.location.host + "/#!/home";
                    $window.location.href = url;
                swal({
                    type: 'success',
                    title: 'Je bent uitgelogd',
                 })
            }
        });
    }
});

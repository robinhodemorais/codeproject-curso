angular.module('app.controllers')
    .controller('LoginController',['$scope','$location','OAuth',function($scope,$location,OAuth){
        $scope.user = {
            username:'',
            password:''
        };

        $scope.login = function(){
            OAuth.getAccessToken($scope.user).then(function(){
                $location.patch('home');
            },function(){
                alert('Login Invalido');
            });
        };
    }]);
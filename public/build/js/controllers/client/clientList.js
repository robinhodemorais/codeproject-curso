angular.module('app.controllers')
    .controller('ClientListController',['$scope', 'Client', function($scope, Client){
        $scope.client = Client.query();


    }]);
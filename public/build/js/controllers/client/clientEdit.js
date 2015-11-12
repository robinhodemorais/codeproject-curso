angular.module('app.controllers')
    .controller('ClientEditController',
    ['$scope', '$location','$routParams', 'Client',
        function($scope, $routParams, $location, Client){

        $scope.client = new Client.get({id: $routeParams.id});

        $scope.save = function(){
            if($scope.form.$valid) {
                Client.update({id: $scope.client.id}, $scope.client, function(){
                    $location.path('/clients');
                    });
            }

        }


    }]);
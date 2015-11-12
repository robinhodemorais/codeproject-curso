angular.module('app.controllers')
    .controller('ClientRemoveController',
    ['$scope', '$location','$routParams', 'Client',
        function($scope, $routParams, $location, Client){

        $scope.client = new Client.get({id: $routeParams.id});

        $scope.remove = function(){
            $scope.client.$delete().then(function (){
                $location.path('/clients');
            });
        }


    }]);
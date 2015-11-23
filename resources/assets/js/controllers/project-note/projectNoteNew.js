angular.module('app.controllers')
    .controller('ProjectNoteNewController',
    ['$scope', '$location', 'Client', function($scope, $location, Client){
        $scope.client = new Client();

        $scope.save = function(){
            if($scope.form.$valid) {
                $scope.client.$save().then().then(function () {
                    $location.path('/clients');
                });
            }

        }


    }]);
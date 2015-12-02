angular.module('app.controllers')
    .controller('ProjectNewController',
    ['$scope', '$location', 'Project','Client',
        function($scope, $location, Project, Client){
            $scope.project = new Project();
            $scope.clitens = new Client();

            $scope.save = function(){
                if($scope.form.$valid) {
                    $scope.project.$save().then().then(function () {
                        $location.path('/projects/');
                    });
                }

            }


        }]);

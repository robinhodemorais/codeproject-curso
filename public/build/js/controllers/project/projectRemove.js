angular.module('app.controllers')
    .controller('ProjectRemoveController',
    ['$scope', '$location','$routeParams', 'Project',
        function($scope, $location, $routeParams, Project){

            $scope.projects = Project.get({id: $routeParams.id});

           // console.log($scope);

        $scope.remove = function(){
            $scope.projects.$delete({id: $scope.projects.id}).then(function (){
                $location.path('/projects/');
            });
        }


    }]);
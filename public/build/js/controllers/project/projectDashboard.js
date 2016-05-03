angular.module('app.controllers')
    .controller('ProjectDashboardController',
    ['$scope', '$location','$routeParams', 'Project',
        function($scope, $location, $routeParams, Project){

            $scope.project = {

            };

            Project.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 15
            }, function(response){
                $scope.projects = response.data;
            });

        $scope.showProject = function (project){
            $scope.project = project;
        }

          //  console.log($scope.projects);

    }]);


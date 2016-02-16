angular.module('app.controllers')
    .controller('ProjectListController',[
        '$scope','$routeParams' ,'Project',
        function($scope, $routeParams, Project){


            $scope.projects = [];
            $scope.totalProjects = 0;
            $scope.projectsPerPage = 15;

            $scope.pagination = {
                current: 1
            };

            //função para quando o usuário clicar em
            //algu,a coisa nova
            $scope.pageChanged = function(newPage) {
                getResultsPage(newPage);
            };

            /* Metodo para chamar o ajax, toda vez que o usuario clicar em alguma coisa
             */
            function getResultsPage(pageNumber) {

                Project.query({}, function(data){
                    $scope.projects = data;
                });

               /* // this is just an example, in reality this stuff should be in a service
                $http.get('path/to/api/users?page=' + pageNumber)
                    .then(function(result) {
                        $scope.users = result.data.Items;
                        $scope.totalUsers = result.data.Count
                    });
                */
            }

            //chama a função na primeira pagina
            getResultsPage(1);

        }]);
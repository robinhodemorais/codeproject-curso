angular.module('app.controllers')
    .controller('ProjectListController',[
        '$scope','$routeParams' ,'Project',
        function($scope, $routeParams, Project){


            $scope.projects = [];
            $scope.totalProjects = 0;
            $scope.projectsPerPage = 5;

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

                Project.query({
                    page: pageNumber,
                    limit: $scope.projectsPerPage
                }, function(data){
                    $scope.projects = data.data;
                    $scope.totalProjects = data.meta.pagination.total;
                });


            }

            //chama a função na primeira pagina
            getResultsPage(1);

        }]);
angular.module('app.controllers').
controller('HomeController',
    ['$scope','$cookies','$timeout','$pusher','Project','ProjectTask','appConfig',
        function($scope,$cookies,$timeout,$pusher,Project,ProjectTask,appConfig){

            $scope.status = appConfig.project.status;
            $scope.statusProject = 0;

            $scope.tasks = [];
            var pusher = $pusher(window.client);
            var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
            channel.bind('CodeProject\\Events\\TaskWasIncluded',
                function (data) {
                    if($scope.tasks.length == 6) {
                        $scope.tasks.splice($scope.tasks.length-1,1)
                    }
                    $timeout(function(){
                        $scope.tasks.unshift(data.task);
                    },1000);

                }
            );


            $scope.project = {

            };

            Project.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 15
            }, function(response){
                $scope.projects = response.data;
               // console.log("Projects" + $scope.projects);
                //var dtAtual = new Date();

                // 0 - Atrasado
                // 1 - Não iniciou
                // 2 - Inicio (sem atraso)
                // 3 - Concluido

               // var i = 0;

                for (var i = 0; i < $scope.projects.length; i++){
                    //se o status for não iniciado
                    if ($scope.projects[i].status == 1) {
                        //verifica se a data de entrega do projeto é menor que a data atual
                        //caso seja está atrasado
                        if ($scope.projects[i].due_date < moment().format("YYYY-MM-DD")) {
                            $scope.projects[i].statusProject = 0;
                        } else {
                            $scope.projects[i].statusProject = 1;
                        }

                        //se iniciou o projeto
                    } else if ($scope.projects[i].status == 2) {
                        //verifica se a data de entrega do projeto é menor que a data atual
                        //caso seja está atrasado
                        if ($scope.projects[i].due_date < moment().format("YYYY-MM-DD")) {
                            $scope.projects[i].statusProject = 0;
                        } else {
                            $scope.projects[i].statusProject = 2;
                        }
                    } else {
                        $scope.projects[i].statusProject = 3;

                    }
                   // console.log($scope.projects[i].description);
                    //console.log("Status : "+$scope.projects[i].statusProject);
                   // console.log("Data de entrega do projeto : "+$scope.projects[i].due_date);
                    //console.log("Status do Projeto : "+$scope.projects[i].status);
                   // console.log("-------");
                }


               // console.log("Tasks " + $scope.projects);
                //console.log("Moment "+ moment().format("YYYY-MM-DD"));
                //console.log("Status do Projeto "+ $scope.statusProject);
            });

            $scope.showProject = function (project){
                $scope.project = project;
            };


       }]);
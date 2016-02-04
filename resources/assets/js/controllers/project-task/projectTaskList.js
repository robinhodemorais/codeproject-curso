angular.module('app.controllers')
    .controller('ProjectTaskListController',[
        '$scope','$routeParams' , 'appConfig', 'ProjectTask', function($scope, $routeParams, appConfig, ProjectTask){
            //armazena os dados do ProjectTask
            $scope.projectTask = new ProjectTask();


        $scope.save = function (){
            if($scope.form.$valid) {
                //pega o primeiro status configurado no appConfig
                $scope.projectTask.status = appConfig.projectTask.status[0].value;
                //chama o save do resource
                $scope.projectTask.$save({$id: $routeParams.id}).then(function () {
                    //zera o formulario criando um novo
                    $scope.projectTask = new ProjectTask();
                    //recarrega as tasks
                    $scope.loadTask();
                });
            }
        };

            //aqui faz a ordenação configurada no repository
            //faz o carregamento das tasks
        $scope.loadTask=function(){
            $scope.projectTask = ProjectTask.query({
               id: $routeParams.id,
                orderBy: 'id',
                sortedBy: 'desc'
            });
        };

            $scope.loadTask();
        //console.log($scope.projectNotes);


    }]);
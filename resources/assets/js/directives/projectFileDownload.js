angular.module('app.directives')
    .directive('projectFileDownload',
    ['appConfig', 'ProjectFile',  function(appConfig,ProjectFile){
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function(scope, element, attr){

            },
            /*
            $element = Serviço que permite ter acesso na diretiva
            var anchor = $element.children()[0]; = pega o elemento da ancora, como
                                                   temos somente 1 elemento então colocamos 0, pois ele é
                                                   o elemento zero
            */
            controller: ['$scope','$element','$attrs',
                function($scope,$element,$attrs){
                    /*
                      desabilita o botão para o download do arquivo
                    */
                    $scope.downloadFile = function (){
                        var anchor = $element.children()[0];
                        $(anchor).addClass('disabled');
                        $(anchor).text('Loading...');
                        ProjectFile.download({id: null, idFile: $attrs.idFile}, function(data){

                        });
                    }
            }]
        };
    }
]);
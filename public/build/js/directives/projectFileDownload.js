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
            controller: ['$scope','$element','$attrs','$timeout',
                function($scope,$element,$attrs,$timeout){
                    /*
                      desabilita o botão para o download do arquivo
                    */
                    $scope.downloadFile = function (){
                        var anchor = $element.children()[0];
                        $(anchor).addClass('disabled');
                        $(anchor).text('Loading...');

                        ProjectFile.download({id: null, idFile: $attrs.idFile}, function(data){
                            $(anchor).removeClass('disabled');
                            $(anchor).text('Save File');

                            /*
                              Indica que temos um dado binário no href e indica que está com o base64
                              */

                            $(anchor).attr({
                                href: 'data:application-octet-stream;base64,'+ data.file,
                                download: data.name
                            });
                            /*TimeOut para dar um leg de segundo para não apresentar erro*/
                            $timeout(function(){

                                 /* após executar a primeira vez, irá limpar o $scope.downloadFile para
                                    não ficar num loop */
                                $scope.downloadFile = function (){

                                };
                                /*irá pegar a ancora e chamar o metodo de click para clicar em download e já baixar o arquivo*/
                                $(anchor)[0].click();
                            });
                        });
                    }
            }]
        };
    }
]);
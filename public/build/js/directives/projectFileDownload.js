angular.module('app.directives')
    .directive('projectFileDownload',
    ['$timeout','$window','appConfig', 'ProjectFile',  function($timeout,$window,appConfig,ProjectFile){
        return {
            restrict: 'E',
            templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
            link: function(scope, element, attr){
                var anchor = element.children()[0];
                /*Evento*/
                scope.$on('salvar-arquivo',function(event,data){

                     $(anchor).removeClass('disabled');
                     $(anchor).text('Save File');
                     blobUtil.base64StringToBlob(data.file).then(function (blob) {
                        /*Indica que temos um dado binário no href e indica que está com o base64*/
                         $(anchor).attr({
                            href: $window.URL.createObjectURL(blob,data.mime_type),
                            download: data.name
                         });

                     });


                     /*TimeOut para dar um leg de segundo para não apresentar erro*/
                     $timeout(function(){

                        /* após executar a primeira vez, irá limpar o $scope.downloadFile para
                            não ficar num loop */
                        scope.downloadFile = function (){
                            $(anchor).text('Download');
                        };
                        /*irá pegar a ancora e chamar o metodo de click para clicar em download e já baixar o arquivo*/
                        $(anchor)[0].click();
                     });
                });
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

                        ProjectFile.download({id: $attrs.idProject, idFile: $attrs.idFile}, function(data){
                            $scope.$emit('salvar-arquivo',data);
                        });
                    }
            }]
        };
    }
]);
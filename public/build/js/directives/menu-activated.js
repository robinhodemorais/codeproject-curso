/*
Diretiva para deixar selecionado o menu
 */
angular.module('app.directives')
    .directive('menuActivated',
    ['$location', function ($location) {
        return {
            restrict: 'A',
            link: function (scope,element,attr) {
                  /*
                    watch metodo ao qual fica assistindo a mudança de algum valor
                   */
                  scope.$watch(function (){
                      // a mudação do location, rota
                      return $location.path();
                      //quando tem uma nova mudança
                  }, function (newValue) {
                      //pegamos todos os li[data-match-route] definido
                      var liElements = element[0].querySelectorAll('li[data-match-route]');
                      //utilizar o angular para fazer um for each em todos os elemtens
                      angular.forEach(liElements, function (li) {
                          //pegamos o li com o angular element
                          var liElement = angular.element(li);
                          //adiciona o patter com expressão regular para verificar se existe alguma rota sobrando
                          var pattern = liElement.attr('data-match-route').replace('/','\\/');
                          var regexp = new RegExp(pattern,'i');
                          //realiza um teste do novo valor
                          //para verificar se a rota acessada bate com o data-match-route
                          if (regexp.test(newValue)){
                              //quando bate ele acrescenta a classe para ativar
                              liElement.children().first().addClass('actived');
                          } else {
                              //quando não bate ele remove a classe de ativação para ativar a proxima.
                              liElement.children().first().removeClass('actived');
                          }

                      });
                  });

            },
        };
    }]);
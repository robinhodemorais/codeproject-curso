/*
Diretiva para verificar se o usuário está autenticado
 */
angular.module('app.directives')
    .directive('loadTemplate',
        ['$compile','$http', 'OAuth',
            function($compile,$http,OAuth) {
                return {
                    restrict: 'E',
                    link: function (scope, element, attr) {
                        //quando o usuário mudar a rota
                        scope.$on('$routeChangeStart', function (event, next, current) {
                            //que o usuário esteja conectado
                            if (OAuth.isAuthenticated()) {
                                if (next.$$route.originalPath != '/login' && next.$$route.originalPath != '/logout') {
                                    if (!scope.isTemplateLoad) {
                                        scope.isTemplateLoad = true;
                                        //carrega o template e pega o elemeto para atribuir o cod. html
                                        $http.get(attr.url).then(function (response) {
                                            element.html(response.data);
                                            //compila o conteudo html do elemento e passa o scopo que quer compilar
                                            //com isso permite carregar o template
                                            $compile(element.contents())(scope);
                                        });
                                    }
                                    return;
                                }
                            }

                            resetTemplate();

                            //apaga o login caso o usuário ja esteja logado
                            function resetTemplate() {
                                scope.isTemplateLoad = false;
                                element.html("");
                            }

                        });

                    },

                };
    }]);
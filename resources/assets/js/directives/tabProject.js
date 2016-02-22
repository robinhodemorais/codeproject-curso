angular.module('app.directives')
    .directive('tabProject',
    [function () {
        return {
            restrict: 'A',
            link: function ($scope, element, attr){
                //pega todo o elemento tabProject do dashboard
                $(element).find('a').click(function(){
                    //pega qual é o elemento que tem a classe tab.content
                    var tabContent = $(element).parent().find('.tab-content'),
                        a = $(this);
                    //pegando, procura-se qual esta ativa e remove a classe dela.
                    tabContent.find('.active').removeClass('active');
                    //procura qual aba que tem o id, baseado na ancora " a = $(this);" acima
                    tabContent.find("[id="+ a.attr('aria-controls')+"]").addClass('active');
                });
            }
        }
    }]);
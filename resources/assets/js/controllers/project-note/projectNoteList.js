angular.module('app.controllers')
    .controller('ProjectNoteListController',[
        '$scope','$routeParams' ,'$compile', '$timeout','$http', '$window', 'ProjectNote',
        function($scope, $routeParams, $compile, $timeout, $http, $window, ProjectNote){
        $scope.projectNotes = ProjectNote.query({id: $routeParams.id});

        $scope.print = function (note) {
            $http.get('/build/views/templates/projectNoteShow.html').then(function (response){
                //passando o scope note, ele sabera que estamos buscando o note
                $scope.note = note;
                //cria um elemento
                var div = $('<div/>');
                //pasa o elemento html,
                div.html($compile(response.data)($scope));
                $timeout(function () {
                    var frame = $window.open('','_blank', 'width=500,height=500');
                    frame.document.open();
                    frame.document.write(div.html());
                    frame.document.close();
                })
            });
        };


    }]);
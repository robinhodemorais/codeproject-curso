angular.module('app.controllers')
    .controller('ProjectNoteRemoveController',
    ['$scope', '$location','$routeParams', 'ProjectNote',
        function($scope, $location, $routeParams, ProjectNote){
            $scope.projectNote = ProjectNote.get({
                id: $routeParams.id,
                noteId: $routeParams.noteId
            });

        $scope.remove = function(){
            $scope.projectNote.$delete({
                id: $routeParams.id, noteId: $scope.projectNote.noteId
            }).then(function (){
                $location.path('/project/' + $routeParams.id + '/notes');
            });
        }


    }]);
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
                id: null, noteId: $scope.projectNote.note_id
            }).then(function (){
                $location.path('/project/' + $routeParams.id + '/notes');
            });
        }


    }]);
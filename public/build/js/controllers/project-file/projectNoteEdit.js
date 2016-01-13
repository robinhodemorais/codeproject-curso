angular.module('app.controllers')
    .controller('ProjectNoteEditController',
    ['$scope', '$location','$routeParams', 'ProjectNote',
        function($scope, $location, $routeParams, ProjectNote){
            $scope.projectNote = ProjectNote.get({
                id: $routeParams.id,
                noteId: $routeParams.noteId
            });

           // console.log($scope.projectNote);

            $scope.save = function(){
                if($scope.form.$valid) {
                    ProjectNote.update({
                        id: null,
                        noteId: $scope.projectNote.noteId}, $scope.projectNote, function(){
                        $location.path('/project/' + $routeParams.id + '/notes');
                    });
                }

            }


        }]);
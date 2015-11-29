angular.module('app.controllers')
    .controller('ProjectNoteEditController',
    ['$scope', '$location','$routeParams', 'ProjectNote',
        function($scope, $location, $routeParams, ProjectNote){
            $scope.projectNote = ProjectNote.get({
                id: $routeParams.id,
                note_id: $routeParams.note_id
            });

            $scope.save = function(){
                if($scope.form.$valid) {
                    ProjectNote.update({
                        id: null,
                        note_id: $scope.projectNote.note_id}, $scope.projectNote, function(){
                        $location.path('/project/' + $routeParams.note_id + '/notes');
                    });
                }

            }


        }]);
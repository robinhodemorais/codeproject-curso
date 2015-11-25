angular.module('app.controllers')
    .controller('ProjectNoteEditController',
    ['$scope', '$location','$routeParams', 'ProjectNote',
        function($scope, $location, $routeParams, ProjectNote){
            $scope.projectNote = ProjectNote.get({
                id: $routeParams.id,
                idNote: $routeParams.idNote
            });

            $scope.save = function(){
                if($scope.form.$valid) {
                    ProjectNote.update({idNote: $scope.projectNote.idNote}, $scope.projectNote, function(){
                        $location.path('/project/' + $routeParams.id + '/notes');
                    });
                }

            }


        }]);
angular.module('app.controllers')
    .controller('ProjectNoteShowController',['$scope', 'ProjectNote', function($scope, ProjectNote){
        $scope.projectNote = ProjectNote.query({id: $routeParams.id});


    }]);
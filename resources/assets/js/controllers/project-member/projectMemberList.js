angular.module('app.controllers')
    .controller('ProjectMemberListController',[
        '$scope','$routeParams' , 'ProjectMember','User', function($scope, $routeParams, ProjectMember, User){
            //armazena os dados do ProjectMember
            $scope.projectMember = new ProjectMember();


        $scope.save = function (){
            if($scope.form.$valid) {
                $scope.projectMember.$save({id: $routeParams.id}).then(function () {
                    $scope.projectMember = new ProjectMember();
                    $scope.loadMember();
                });
            }
        };

        $scope.loadMember=function(){
            $scope.projectMember = ProjectMember.query({
               id: $routeParams.id,
                orderBy: 'id',
                sortedBy: 'desc'
            });

        };

         $scope.formatName = function (model) {
             if(model){
                 return model.name;
             }

             return '';
         };

            $scope.getUser = function(name){
                return User.query({
                    search: name,
                    searcheFields: 'name:like'
                }).$promise;
            }

            $scope.selectUser = function (item){
              $scope.projectMember.member_id = item.id;
             //   $scope.projectMember.user_id = item.id;
            };


         $scope.loadMember();

    }]);
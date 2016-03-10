angular.module('app.controllers').
controller('HomeController',
    ['$scope','$cookies','$timeout','$pusher','Project',
        function($scope,$cookies,$timeout,$pusher,Project){

            $scope.tasks = [];
            var pusher = $pusher(window.client);
            var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
            channel.bind('CodeProject\\Events\\TaskWasIncluded',
                function (data) {
                    if($scope.tasks.length == 6) {
                        $scope.tasks.splice($scope.tasks.length-1,1)
                    }
                    $timeout(function(){
                        $scope.tasks.unshift(data.task);
                    },1000);

                }
            );


            $scope.project = {

            };

            Project.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 5
            }, function(response){
                $scope.projects = response.data;
            });

            $scope.showProject = function (project){
                $scope.project = project;
            }





        }]);
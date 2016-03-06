angular.module('app.controllers')
    .controller('RefreshModalController',
        ['$rootScope', '$scope', '$location','$modalInstance','authService' ,'User', 'OAuth','OAuthToken',
        function($rootScope, $scope, $location,
                 $modalInstance,authService, User, OAuth, OAuthToken){

            //fecha o model
            $scope.$on('event:auth-loginConfirmed', function(){
                $rootScope.loginModalOpened = false;
                $modalInstance.close();
            });

            $scope.$on('$routeChangeStart', function(){
                $rootScope.loginModalOpened = false;
                $modalInstance.dismiss('cancel');
            });

            $scope.$on('event:auth-loginCancelled', function(){
                OAuthToken.removeToken();
            });

            $scope.cancel = function (){
                authService.loginCancelled();
                $location.path('login');
            }

            OAuth.getRefreshToken().then(function(){
                    authService.loginConfirmed();
            },function(data){
                $scope.cancel();
            });

        }]);
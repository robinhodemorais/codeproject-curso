angular.module('app.services')
    .service('ProjectNote',['$resource','appConfig', function($resource,appConfig){
        return $resource(appConfig.baseUrl + '/project/:id/notes',{id: '@id'},{
            update: {
                method: 'PUT'
            }
        });
    }
]);
angular.module('app.services')
    .service('ProjectNote',['$resource','appConfig', function($resource,appConfig){
        return $resource(appConfig.baseUrl + '/project/:id/notes/:idNote',{
            id: '@id',
            idNote: '@idNote'
        },{
            update: {
                method: 'PUT'
            }
        });
    }
]);
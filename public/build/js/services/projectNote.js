angular.module('app.services')
    .service('ProjectNote',['$resource','appConfig', function($resource,appConfig){
        return $resource(appConfig.baseUrl + '/project/:id/notes/:noteId',{
            id: '@id',
            noteId: '@noteId'
        },{
            update: {
                method: 'PUT'
            }
        });
    }
    ]);
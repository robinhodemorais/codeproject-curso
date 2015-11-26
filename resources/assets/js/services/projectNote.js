angular.module('app.services')
    .service('ProjectNote',['$resource','appConfig', function($resource,appConfig){
        return $resource(appConfig.baseUrl + '/project/:id/notes/:note_id',{
            id: '@id',
            note_id: '@note_id'
        },{
            update: {
                method: 'PUT'
            }
        });
    }
    ]);
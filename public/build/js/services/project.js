angular.module('app.services')
    .service('Project',['$resource','$filter','$httpParamSerializer','appConfig', function($resource,$filter,$httpParamSerializer,appConfig){
        return $resource(appConfig.baseUrl + '/projects/:id',{id: '@id'},{
            save: {
              method: 'POST',
                transformRequest: function (data) {
                    //verifica se o objeto é data e é o campo due_date
                    if(angular.isObject(data) && data.hasOwnProperty('due_date')){
                        data.due_date = $filter('date')(data.due_date,'yyyy-MM-dd');
                        return $httpParamSerializer(data);
                    }
                    return data;
                }
            },
            update: {
                method: 'PUT'
            }
        });
    }
    ]);
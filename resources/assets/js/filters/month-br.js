angular.module('app.filters').filter('monthBr',['$filter',function($filter){
    return function (input){
       return $filter('date')(input,'dd/MM/yyyy');
        //return $moment('due_date')(input,'MMM');

       //var moment = require('moment');
        //return moment('due_date').format('MMM');
    }
}]);
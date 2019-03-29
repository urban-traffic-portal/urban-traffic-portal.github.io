/**
 * Created by Ngo Thanh Tung on 3/13/2016.
 */

// App
var app = angular.module('aptech', [
    'ngRoute',
]);


// Config
function config($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: 'views/home.html',
            controller: 'HomeController',
            data: { pageTitle: 'HOME' }
        })
        .when('/about', {
            templateUrl: 'views/about.html',
            controller: 'AboutController',
            data: { pageTitle: 'ABOUT' }
        })
        .when('/json', {
            templateUrl: 'views/json.html',
            controller: 'JsonController',
            data: { pageTitle: 'JSON' }
        })
        .otherwise({ redirectTo: '/home' });
}


app.config(config);

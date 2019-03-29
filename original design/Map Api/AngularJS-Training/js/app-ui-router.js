/**
 * Created by Ngo Thanh Tung on 3/13/2016.
 */


var app = angular.module('aptech', [
    'ui.router',
]);

function config($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise("/home");

    $stateProvider
        .state('home', {
            url: '/home',
            templateUrl: 'views/home.html',
            controller: 'HomeController',
            data: { pageTitle: 'HOME' }
        })
        .state('about', {
            url: '/about',
            templateUrl: 'views/about.html',
            controller: 'AboutController',
            data: { pageTitle: 'ABOUT' }
        })
        .state('json', {
            url: '/json',
            templateUrl: 'views/json.html',
            controller: 'JsonController',
            data: { pageTitle: 'JSON' }
        });
}

app.config(config);
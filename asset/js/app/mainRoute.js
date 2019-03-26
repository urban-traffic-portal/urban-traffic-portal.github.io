    var routerApp = angular.module('routerApp', ['ui.router']);
    routerApp.config(function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/home');
        $stateProvider
            .state('home', {
                url: '/home',
                views: {
                    // the main template will be placed here (relatively named)
                    '': { templateUrl: './asset/views/home.html' },
                    'navbar@home': { templateUrl: './asset/views/navGuest.html' },
                    'sidebar@home': { templateUrl: './asset/views/sidebar.html' },
                    'pageTraffic@home': { templateUrl: './asset/views/pageTraffic.html' },
                    'overlay@home': { templateUrl: './asset/views/overlay.html' },
                }
            })
            .state('about', {
                url: '/about',
                views: {
                    // the main template will be placed here (relatively named)
                    '': { templateUrl: './asset/views/about.html' },
                    // the child views will be defined here (absolutely named)
                    'columnOne@about': { template: 'Look I am a column!' },
                }
            });

    }); // closes $routerApp.config()
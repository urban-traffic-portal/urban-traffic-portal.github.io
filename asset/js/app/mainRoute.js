var routerApp = angular.module('routerApp', ['ui.router']);
routerApp.controller('mapcontroller', function ($scope, $http,$interval) {
  $scope.events = "";
  $scope.data="";
  $scope.mainmap = "";
  $scope.mainmap = initMap(-34.397, 150.644, 16);
  var url = "./asset/data/roadevent/event.json";
  $http.get(url).then(function (response) {
    console.log(response.data);
    $scope.events = response.data;
    $scope.data= response.data;
  });
  $scope.add = function () {
    $scope.events.push(value);
  }
  $scope.removeRow = function () {
    $scope.events.pop();
  };
  $interval($scope.add, 2000); 
  $interval($scope.removeRow, 4000); 
});
routerApp.controller('shopController', function ($scope) {
  // Show item to the page
  $scope.products = products;
  // Get the select item
  var selectedItems = [];
  $scope.selectedItems = selectedItems;
  // Click select item event
  $scope.addToCart = function (product) {
    var existItem = {};
    // Check an exist item in the ShopCart
    angular.forEach($scope.selectedItems, function (item, index) {
      if (item.id === product.id) {
        existItem = item;
        return false;
      }
    });

    // If exist item ++
    if (existItem.id !== undefined) {
      existItem.quantity++;
    }
    // Else add to catch
    else {
      var cartItem = angular.copy(product);
      cartItem.quantity = 1;
      $scope.selectedItems.push(cartItem);
    }
  };

  // Remove item  from cart
  $scope.remove = function (cartItem) {
    var index = $scope.selectedItems.indexOf(cartItem);
    $scope.selectedItems.splice(index, 1);
  };

  $scope.getTotal = function () {
    var total = 0;
    angular.forEach($scope.selectedItems, function (item, index) {
      total += (item.price * item.quantity);
    })
    return total;
  }
});
routerApp.controller("contentController", function ($scope, $http, $sce) {
  $scope.percent = 0;
  $scope.loadContent = "";
  $scope.loadProgress = "";
  var url = "./asset/data/rule/list.json";
  $http.get(url).then(function (response) {
    console.log(response.data);
    $scope.contents = response.data;
  });
  //Load select to content
  $scope.load = function (textname) {

    var link = $scope.target = "./asset/data/rule/" + textname;
    $http.get(link).then(function (response) {
      $scope.contents = response.data;
      $scope.loadContent = $sce.trustAsHtml(response.data);
    });
  }
  $scope.up = function () {
    $scope.percent = $scope.percent + 11.11;
    var html = '<div class="progress"><div class="progress-bar" role="progressbar" value="' + $scope.percent + '%" style="width:' + $scope.percent + '%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
    $scope.loadProgress = $sce.trustAsHtml(html);
  }
});
routerApp.config(function ($stateProvider, $urlRouterProvider) {
  $urlRouterProvider.otherwise('/home');
  $stateProvider
    .state('home', {
      url: '/home',
      templateUrl: './asset/views/map.html',
      controller: 'mapcontroller'
    })
    .state('shop', {
      url: '/shop',
      templateUrl: './asset/views/shop.html',
      controller: 'shopController'
    })
    .state('rule', {
      url: '/rule',
      templateUrl: './asset/views/rule.html',
      controller: 'contentController'
    })
    .state('about', {
      url: '/about',
      templateUrl: './asset/views/about.html'
    })
    .state('contact', {
      url: '/contact',
      templateUrl: './asset/views/contact.html'
    })
});


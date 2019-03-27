var routerApp = angular.module('routerApp', ['ui.router']);
routerApp.controller('mapcontroller',function($scope){
  $scope.mainmap = "";
  $scope.mainmap =initMap(-34.397, 150.644, 16);
  function initMap(userlat, userlong, userzoom) {
    // The location of Uluru
    var uluru = { lat: userlat, lng: userlong };
    // The map, centered at Uluru
    var thisMap = new google.maps.Map(
      document.getElementById('map'), { zoom: userzoom, center: uluru, mapTypeId: 'roadmap' });
    var bikeLayer = new google.maps.BicyclingLayer();
    bikeLayer.setMap(thisMap);
    new AutocompleteDirectionsHandler(thisMap);
    //Autocmplete
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    thisMap.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    thisMap.addListener('bounds_changed', function () {
      searchBox.setBounds(thisMap.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function () {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // Clear out the old markers.
      markers.forEach(function (marker) {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function (place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };
        // Create a marker for each place.
        markers.push(new google.maps.Marker({
          map: thisMap,
          icon: icon,
          title: place.name,
          position: place.geometry.location
        }));

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      thisMap.fitBounds(bounds);
    });
    infoWindow = new google.maps.InfoWindow;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        infoWindow.setPosition(pos);
        infoWindow.setContent('Location found.');
        infoWindow.open(thisMap);
        thisMap.setCenter(pos);
      }, function () {
        handleLocationError(true, infoWindow, thisMap.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, thisMap.getCenter());
    }

    google.maps.event.addListener(thisMap, 'click', function (event) {
      addMarker(event.latLng, thisMap);
    });
    // This event listener will call addMarker() when the map is clicked.

    //TRAFFICE LAYER
    //var trafficLayer = new google.maps.TrafficLayer();
    //trafficLayer.setMap(thisMap);

    return mymap;
  }
  function addMarker(location, thismap) {
    var marker = new google.maps.Marker({
      position: location,
      map: thismap
    });
    marker.setMap(thismap);
    markers.push(marker);
  }
  // Sets a listener on a radio button to change the filter type on Places
// Autocomplete.
AutocompleteDirectionsHandler.prototype.setupClickListener = function(
  id, mode) {
var radioButton = document.getElementById(id);
var me = this;

radioButton.addEventListener('click', function() {
  me.travelMode = mode;
  me.route();
});
};

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(
  autocomplete, mode) {
var me = this;
autocomplete.bindTo('bounds', this.map);

autocomplete.addListener('place_changed', function() {
  var place = autocomplete.getPlace();

  if (!place.place_id) {
    window.alert('Please select an option from the dropdown list.');
    return;
  }
  if (mode === 'ORIG') {
    me.originPlaceId = place.place_id;
  } else {
    me.destinationPlaceId = place.place_id;
  }
  me.route();
});
};

AutocompleteDirectionsHandler.prototype.route = function() {
if (!this.originPlaceId || !this.destinationPlaceId) {
  return;
}
var me = this;

this.directionsService.route(
    {
      origin: {'placeId': this.originPlaceId},
      destination: {'placeId': this.destinationPlaceId},
      travelMode: this.travelMode
    },
    function(response, status) {
      if (status === 'OK') {
        me.directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
};
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
      templateUrl:  './asset/views/rule.html',
      controller: 'contentController'
    })
    .state('about', {
      url: '/about',
      templateUrl:  './asset/views/about.html'
    })
    .state('contact', {
      url: '/contact',
      templateUrl:  './asset/views/contact.html'
    })
}); 
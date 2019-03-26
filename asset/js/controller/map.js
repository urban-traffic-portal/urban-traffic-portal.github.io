  var iconBase =
  'https://developers.google.com/maps/documentation/javascript/examples/full/images/';
  var mymap,infoWindow;
  var markers = [];
$(document).ready(function () {
  mymap= initMap(-34.397, 150.644, 16);
});
function initMap(userlat, userlong, userzoom) {
  // The location of Uluru
  var uluru = { lat: userlat, lng: userlong };
  // The map, centered at Uluru
  var thisMap = new google.maps.Map(
  document.getElementById('map'), { zoom: userzoom, center: uluru });
  infoWindow = new google.maps.InfoWindow;
  // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(thisMap);
            thisMap.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, thisMap.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, thisMap.getCenter());
        }

  google.maps.event.addListener(thisMap, 'click', function (event) {
    addMarker(event.latLng,thisMap);
  });
  // This event listener will call addMarker() when the map is clicked.
  return mymap;
}
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert("Geolocation is not supported by this browser");
  }
}
function showPosition(position) {
  mymap= initMap(position.coords.latitude, position.coords.longitude,16);
}
// Adds a marker to the map and push to the array.
function addMarker(location,thismap) {
  var marker = new google.maps.Marker({
    position: location,
    map: thismap
  });
  marker.setMap(thismap);
  markers.push(marker);
}
//
function Icons(name){
  var icons = {
    parking: {
      icon: iconBase + 'parking_lot_maps.png'
    },
    library: {
      icon: iconBase + 'library_maps.png'
    },
    info: {
      icon: iconBase + 'info-i_maps.png'
    }
  };
}

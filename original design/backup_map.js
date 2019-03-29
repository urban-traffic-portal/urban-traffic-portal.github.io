var marker = false;
var mymap = "";
$(document).ready(function () {
    var mymap = new mapObject(-28.024, 140.887, 5, "map");
    mymap.load();
    google.maps.event.addListener(map, 'click', function (event) {
      placeMarker(map, event.latLng, "text");
    });
});
function mapObject(x, y, z, id) {
    this.locations = new Array();
    this.map = new google.maps.Map("", "");
    this.x = x;
    this.y = y;
    this.z = z;
    this.id = id;
    //This function load new map
    this.load = function () {
      // Creating a reference to the mapDiv
      var mapDiv = document.getElementById(this.id);
      // Creating a latLng for the center of the map
      var latlng = new google.maps.LatLng(this.x, this.y);
      // Creating an object literal containing the properties 
      // we want to pass to the map  
      var options = {
        center: latlng,
        zoom: this.z,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        navigationControl: true,
       
      };
      map = new google.maps.Map(mapDiv, options);
      var trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(map);
      // Creating the map
      //
      return map;
    }
    this.marker = function (markX, markY, markName) {
      this.locations.push({ lat: markX, lng: markY, label: markName });
      console.log(this.locations);
      // Create an array of alphabetical characters used to label the markers.
      // Add some markers to the map.
      // Note: The code uses the JavaScript Array.prototype.map() method to
      // create an array of markers based on a given "locations" array.
      // The map() method here has nothing to do with the Google Maps API.
      var markers = this.locations.map(function (location, i) {
        console.log("1" + location["lat"]);
        console.log("1" + location["lng"]);
        console.log("1" + location["label"]);
        var currentPos = { lat: location["lat"], lng: location["lng"] }
        return new google.maps.Marker({
          position: currentPos,
          label: location["label"]
        });
      });
      // Add a marker clusterer to manage the markers.
      var markerCluster = new MarkerClusterer(map, markers,
        { imagePath: '' });
    }
    //End Mark
  }
  function placeMarker(map, location, text) {
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
    google.maps.event.addListener(marker, 'click', function () {
      map.setZoom(9);
      map.setCenter(marker.getPosition());
    });
    var infowindow = new google.maps.InfoWindow({
      content: text
      // 'Latitude: ' + location.lat() +
      //'<br>Longitude: ' + location.lng()
    });
    infowindow.open(map, marker);
  }
  $(0).each(function (index, element) {
    // element == this
    
  });
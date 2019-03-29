var marker = false;
var mymap="";
(function () {
  window.onload = function () {
    var mymap = new mapObject(-28.024, 140.887, 4, "map");
    mymap.load();
    //mymap.z=4;
    mymap.load();
    mymap.marker(-33.848588, 151.209834, "2");
    mymap.marker(-37.819616, 144.968119, "3");
    google.maps.event.addListener(map, 'click', function( event ){
     // alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() );
       mymap.marker(event.latLng.lat(),event.latLng.lng(),"");
     });
  }
})();
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        position: google.maps.ControlPosition.TOP,
        mapTypeIds: [
          google.maps.MapTypeId.ROADMAP,
          google.maps.MapTypeId.SATELLITE
        ]
      }
    };
    // Creating the map
    map = new google.maps.Map(mapDiv, options);
    
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
//https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m


var geocoder;
var map;
var markers = Array();
var infos = Array();
var lat = -37.8136;
var lng = 144.9631;
var layers = [];


//Initialize the google map canvas
function initialize() 
{

    //Position starts at Melbourne
    var myLatlng = new google.maps.LatLng(-37.8136,144.9631);
    //Default map options
    var myOptions = 
    { 
        zoom: 14,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

    //Public data kept in .kml files in google cloud storage
   layers [0] = new google.maps.KmlLayer('https://storage.googleapis.com/toiletfinder123.appspot.com/Public_toilets.kml',
    {preserveViewport: false, suppressInfoWindows: false});
  for (var i = 0; i < layers.length; i++) 
  {
          layers[i].setMap(null);
  }
}


//Menu functions below
//Toggles the stored .kml file when the checkbox is clicked
function toggleLayer(i) 
{
  if (layers[i].getMap() === null) 
  {
    layers[i].setMap(map);
  }
  else 
  {
    layers[i].setMap(null);
  }
}

//Clears the map on a new search 
function clearMap() 
{
    if (markers) {
        for (i in markers) {
            markers[i].setMap(null);
        }
        markers = [];
        infos = [];
    }
}

//Clears the info windows when a new marker is clicked
function clearInfos() 
{
    if (infos) {
        for (i in infos) {
            if (infos[i].getMap()) {
                infos[i].close();
            }
        }
    }
}

//Function for the locateMe button
function locateMe() 
{
    if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      lat = position.coords.latitude;
      lng = position.coords.longitude;
      var pos = new google.maps.LatLng(lat, lng);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'You are here!'
      });

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

//Function for the searchPlaces button
function searchPlaces() 
{
    //Takes all variables
    var type = document.getElementById('map_type').value;
    var radius = document.getElementById('map_radius').value;
    var pos = new google.maps.LatLng(lat, lng);
    //Requests google places using the above variables
    var request = {
        location: pos,
        radius: radius,
        types: [type]
    };
    //Request sent
    service = new google.maps.places.PlacesService(map);
    service.search(request, createMarkers);
}

//Create markers from the searchPlaces() function
function createMarkers(results, status) 
{
    if (status == google.maps.places.PlacesServiceStatus.OK) {

        //If results are found the map is cleared
        clearMap();
        //And the new markers are generated
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    } else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
        alert('Sorry, Nothing found in this area');
    }
}


//Info window for single markers
function createMarker(place) 
{
    var mark = new google.maps.Marker({
        position: place.geometry.location,
        map: map,
        title: place.name
    });
    markers.push(mark);

    //Info Window section
    var infowindow = new google.maps.InfoWindow({
        content: '<strong>Name: </strong>' + place.name  + '<br /><strong>Address:</strong> ' + place.vicinity + '<br /><strong>Rating:</strong> ' + place.rating  + '<br /><strong>Price Level:</strong> ' + place.price_level
    });

    //Event handler for click
    google.maps.event.addListener(mark, 'click', function() {
        clearInfos();
        infowindow.open(map,mark);
    });
    infos.push(infowindow);
}


//Menu icon scripts below
function checkNav() 
{
  if (document.body.classList.contains('menu-icon-active')) 
  {
      closeNav();
  } else 
  {
    openNav();
  }
}

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

//Begin initialize() function on page load
google.maps.event.addDomListener(window, 'load', initialize);

// JavaScript Document
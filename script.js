var geocoder;
var map;
var markers = Array();
var infos = Array();
var lat = -37.8136;
var lng = 144.9631;
var layers = [];
var markerMe;
var infowindow;
var locationMe = new google.maps.LatLng(lat,lng);
var directionsService = new google.maps.DirectionsService;
var directionsDisplay = new google.maps.DirectionsRenderer;

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
        mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: true,
          mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
              position: google.maps.ControlPosition.LEFT_BOTTOM
          }
    };
    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

	var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
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
              map: map,
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
          map.fitBounds(bounds);
        });
    //Public data kept in .kml files in google cloud storage
    layers [0] = new google.maps.KmlLayer('https://sites.google.com/site/toiletfinder666/kmz/indoor.kmz',
    {preserveViewport: false, suppressInfoWindows: true});
	layers [1] = new google.maps.KmlLayer('https://sites.google.com/site/toiletfinder666/kmz/outdoor.kmz',
    {preserveViewport: false, suppressInfoWindows: true});
	layers [2] = new google.maps.KmlLayer('https://sites.google.com/site/toiletfinder666/kmz/baby.kmz',
    {preserveViewport: false, suppressInfoWindows: true});
	layers [3] = new google.maps.KmlLayer('https://sites.google.com/site/toiletfinder666/kmz/accessible.kmz',
    {preserveViewport: false, suppressInfoWindows: true});
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
    layers[i].addListener('click', function(kmlEvent){
    	var text = kmlEvent.featureData.description;
    	var contentString = '<div id="content">'+
        '<h5 >'+text+'</h5>'+
        '<div style="float:right">'+
        '<a href="javascript:go'+kmlEvent.latLng+';">Show me the path</a>'+
        '</div>'+
        '</div>';
    	if (infowindow!=null) {
    		infowindow.close();
	}
	infowindow = new google.maps.InfoWindow({
	      content: contentString,
	      disableAutoPan: true,
	      position: kmlEvent.latLng,
	 });
	    infowindow.open(map, this);
    });
  }
  else 
  {
    layers[i].setMap(null);
  }
}

function go(Lat,Lng){

    directionsDisplay.setMap(map);
    calculateAndDisplayRoute(directionsService, directionsDisplay,Lat,Lng);
	
}
function calculateAndDisplayRoute(directionsService, directionsDisplay,Lat,Lng) {
    directionsService.route({
      origin: locationMe,
      destination: new google.maps.LatLng(Lat,Lng),
      travelMode: 'WALKING'
    }, function(response, status) {
      if (status === 'OK') {
        directionsDisplay.setDirections(response);
    	if (infowindow!=null) {
    		infowindow.close();
		}
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  }


//Function for the locateMe button
function locateMe() 
{
    if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      lat = position.coords.latitude;
      lng = position.coords.longitude;
      var pos = new google.maps.LatLng(lat, lng);
      locationMe = pos;
      ;
      // add marker    
      if(typeof(markerMe)=="undefined"){
    	  markerMe = new google.maps.Marker({
    		  position: pos,
    		  map: map,
    		  title:"You are here!"
    	  });
    	  markerMe.setAnimation(google.maps.Animation.BOUNCE);
      }else{
    	  markerMe.setAnimation(google.maps.Animation.BOUNCE);
    	  
      }
	    
      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
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

function popupOpenClose() {
	
	/* Add div inside popup for layout if one doesn't exist */
	if ($(".wrapper").length == 0){
		$(popup).wrapInner("<div class='wrapper'></div>");
	}
	
	/* Open popup */
	$(popup).show();

	/* Close popup if user clicks on background */
	$(popup).click(function(e) {
		if ( e.target == this ) {
			if ($(popup).is(':visible')) {
				$(popup).hide();
			}
		}
	});

	/* Close popup and remove errors if user clicks on cancel or close buttons */
	$(popup).find("button[name=close]").on("click", function() {
		if ($(".formElementError").is(':visible')) {
			$(".formElementError").remove();
		}
		$(popup).hide();
	});
}


/*add toilet function*/
 function adding() {

        infowindow = new google.maps.InfoWindow({
          content: document.getElementById('addform')
        });

        messagewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });

        google.maps.event.addListener(map, 'click', function(event) {
          marker = new google.maps.Marker({
            position: event.latLng,
            map: map
          });


          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });
        });
      }

      function saveData() {

        var type = document.getElementById('type').value;
		var gender = document.getElementById('gender').value;
		var baby = document.getElementById('baby').value;
		var disable = document.getElementById('disable').value;
		var description = document.getElementById('description').value;
		
        var latlng = marker.getPosition();
        var url = '#?type=' + type + '&gender=' + gender +
                  '&baby=' + baby + '&disable=' + disable + '&lat=' + latlng.lat() + '&lng=' + latlng.lng()+ '&description=' + description;

        downloadUrl(url, function(data, responseCode) {

          if (responseCode == 200 && data.length <= 1) {
            infowindow.close();
            messagewindow.open(map, marker);
          }
        });
      }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing () {
      }



//Begin initialize() function on page load
google.maps.event.addDomListener(window, 'load', initialize);


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

var marker;
var messagewindow;


<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    //border-collapse: collapse;
    width: 400px;
}

td, th {
    width:100px;
    text-align: center;
    padding: 8px;
}

th {
    background-color: green;
    color: white;
}

</style>
</head>
<body>


<h3>Hi! <?php echo $_SESSION['user'];?>. </h3>

<FORM ACTION="../server/logout.php" method="POST">
<button type="submit">Log out</button>
</FORM>

<br/><br/>This is your shopping cart, only the successful login user can access to here<br/><br/>

<FORM ACTION="../server/order.php" method="POST">
<table>
  <tr>
    <th>Products</th>
    <th>Price</th>
	<th>Quantity</th>
	<th>Subtotal</th>
  </tr>
  <tr>
    <td>Product A<input type="hidden" name="ProductA" id="ProductA" value="ProductA"/></td>
    <td>$10<input type="hidden" name="ProductAprice" id="ProductAprice" value="10"/></td>
	<td><input id="ProductAquantity" name="ProductAquantity" type="number" value="0" min="0" max="10" onclick="updateCart()"/></td>
	<td><p id="ProductAsubtotal">0</p><input id="ProductAtotal" name="ProductAtotal" type="hidden"/></td>
  </tr>
  <tr>
    <td>Product B<input type="hidden" name="ProductB" id="ProductB" value="ProductB"/></td>
    <td>$15<input type="hidden" name="ProductBprice" id="ProductBprice" value="15"/></td>
	<td><input id="ProductBquantity" name="ProductBquantity" type="number" value="0" min="0" max="10" onclick="updateCart()"/></td>
	<td><p id="ProductBsubtotal">0</p><input id="ProductBtotal" name="ProductBtotal" type="hidden"/></td>
  </tr>
  <tr>
    <td>Product C<input type="hidden" name="ProductC" id="ProductC" value="ProductC"/></td>
    <td>$20<input type="hidden" name="ProductCprice" id="ProductCprice" value="20"/></td>
	<td><input id="ProductCquantity" name="ProductCquantity" type="number" value="0" min="0" max="10" onclick="updateCart()"/></td>
	<td><p id="ProductCsubtotal">0</p><input id="ProductCtotal" name="ProductCtotal" type="hidden"/></td>
  </tr>
  <tr>
    <th></th>
    <th>Total</th>
	<th><p id="Quantity" >0</p><input id="totalQuantity" name="totalQuantity" type="hidden"/></th>
	<th><p id="Price" >0</p><input id="totalPrice" name="totalPrice" type="hidden"/></th>
  </tr>
	<tr>
    <td colspan="2" style="text-align: right;">Your DES key:</td>
	<td colspan="2"><input type="text" name="DES_key" id="DES_key"/></td>
  </tr>
  </tr>
	<tr>
    <td colspan="2" style="text-align: right;">Credit Card Number:</td>
	<td colspan="2"><input maxlength="16" id="cardNumber" name="cardNumber" type="text"/></td>
  </tr>
  <tr>
    <th></th>
    <th></th>
	<th></th>
	<th><button type="submit" id="submit" name="submit" onclick="encrypt_before_submit()">Submit</button></th>
  </tr>
</table>


</FORM>

<?php

	}
	
?>

<script type="text/javascript" src="js/rsa.js"></script>
<script type="text/javascript" src="js/sha256.js"></script>
<script type="text/javascript" src="js/des.js"></script>
<script type="text/javascript">
		
		function encrypt_before_submit(){
			
			var DES_key = document.getElementById("DES_key").value; 
			var encrypted_DES_key = RSA_encrypt(DES_key);
			document.getElementById("DES_key").value = encrypted_DES_key;
			
			var cardNumber = document.getElementById("cardNumber").value; 
			var encrypted_creditCard = javascript_des_encryption(DES_key, cardNumber);
			document.getElementById("cardNumber").value = encrypted_creditCard;

		}
		
		function RSA_encrypt(message){
			
			var pubilc_key = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzdxaei6bt/xIAhYsdFdW62CGTpRX+GXoZkzqvbf5oOxw4wKENjFX7LsqZXxdFfoRxEwH90zZHLHgsNFzXe3JqiRabIDcNZmKS2F0A7+Mwrx6K2fZ5b7E2fSLFbC7FsvL22mN0KNAp35tdADpl4lKqNFuF7NT22ZBp/X3ncod8cDvMb9tl0hiQ1hJv0H8My/31w+F+Cdat/9Ja5d1ztOOYIx1mZ2FD2m2M33/BgGY/BusUKqSk9W91Eh99+tHS5oTvE8CI8g7pvhQteqmVgBbJOa73eQhZfOQJ0aWQ5m2i0NUPcmwvGDzURXTKW+72UKDz671bE7YAch2H+U7UQeawwIDAQAB-----END PUBLIC KEY-----";		
			
			var encrypt = new JSEncrypt();
			encrypt.setPublicKey(pubilc_key);
			var encrypted = encrypt.encrypt(message);
			
			return encrypted;
			
		}
		
</script>


<script type="text/javascript">

		function updateCart(){

			var total = calcSubTotal('ProductA')+calcSubTotal('ProductB')+calcSubTotal('ProductC');
			
			var quantity = parseInt(document.getElementById('ProductAquantity').value)+parseInt(document.getElementById('ProductBquantity').value)+parseInt(document.getElementById('ProductCquantity').value);
			
			var DES_key = document.getElementById("DES_key").value;
			var cardNumber = document.getElementById("cardNumber").value;
			
			document.getElementById("Quantity").innerHTML = quantity;
			document.getElementById("totalQuantity").value = quantity;
			
			document.getElementById("Price").innerHTML = total;
			document.getElementById("totalPrice").value = total;
		}

		function calcSubTotal(productName){
			
			var quantity = parseInt(document.getElementById(productName+'quantity').value);
			if(quantity > 0){
				var price = parseInt(document.getElementById(productName+'price').value);
			
				var subtotal = price * quantity;
				document.getElementById(productName+"subtotal").innerHTML = subtotal;
				document.getElementById(productName+"total").value = subtotal;
				return subtotal;
			}
			document.getElementById(productName+"subtotal").innerHTML = 0;
			document.getElementById(productName+"total").value = 0;
			return 0;
		}
</script>

</body>
</html>
















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
        '<a href="javascript:go'+kmlEvent.latLng+';">Go here</a>'+
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


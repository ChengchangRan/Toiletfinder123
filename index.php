<!DOCTYPE html>
<!-- database using XML file -->
<?php

require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('35.188.198.174', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "SELECT * FROM markers WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("type",$row['type']);
  $newnode->setAttribute("gender", $row['gender']);
  $newnode->setAttribute("baby", $row['baby']);
  $newnode->setAttribute("disable", $row['disable']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("description", $row['description']);
}

echo $dom->saveXML();

?>

<html>

  <header>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="utf-8">

    <title>Melbourne Toilet Finder</title>
    
    <link href="main.css" rel="stylesheet" type="text/css" />
    <!-- Use fontawesome-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
    <!-- add toilet right list css-->
    <link rel="stylesheet" type="text/css" href="component.css" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:300">
    <link href="//cdn.muicss.com/mui-latest/css/mui.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="modal-box.min.css" media="screen">
<link rel="stylesheet" href="custom.min.css" media="screen">
<script src="//cdn.muicss.com/mui-latest/js/mui.min.js"></script>
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

	<!-- Google maps API/Google places API-->

	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyABisuaAu1IDWBncs_GHZ5MdLVsfchAVxY&language=en"></script>

	<script src="script.js"></script>
	<script src="sidescript.js"></script>
	
		
	<!-- add toilet right list script -->
	<script src="modernizr.custom.js"></script>
	
	
<script asyn src="https://ajax.googleapis.com/ajax/libs/webfont/1.6/webfont.js"></script>
<script>
/*! Webfontloader */
WebFont.load({
    google: {
      families: [ 'Open+Sans', 'Noto+Sans' ]
	}
});
(function() {
	var wf = document.createElement('script');
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1.6/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(wf, s);
});
</script>

<noscript>
	<link rel="prefetch" href="https://fonts.googleapis.com/css?family=Open+Sans|Noto+Sans&amp;lang=en" media="screen">
</noscript>
  </header>

  <body>
          <div id="sidedrawer" class="mui--no-user-select">
      <div id="sidedrawer-brand" class="mui--appbar-line-height">
        <span class="mui--text-title">ToiletFinder</span>
      </div>
      <div class="mui-divider"></div>
      <ul>
        <li>
          <a href="#" onclick="locateMe();" return false;><strong>
                        <i class="fa fa-map-marker fa-2x"></i>
                        <span class="nav-text">
                            Locate me
			  </span></strong>
                    </a>
        </li>
        <li>
          <a href="#" onclick="toggleLayer(0);"><strong>
                       <i class="fa fa-search fa-2x"></i>
                        <span class="nav-text">
                            Find toilet
			  </span></strong>
                    </a>
        </li>
        <li>
          <a href="#" id="showRight"><strong>
                       <i class="fa fa-plus-square fa-2x"></i>
                        <span class="nav-text">
                           Add toilet
			  </span></strong>
                    </a>
        </li>
        <li>
          <a href="#openModal"id="link1">
                      <strong>
                       <i class="fa fa-info fa-2x"></i>
                        <span class="nav-text">
                            About
						  </span></strong>
                    </a>
        </li>
      </ul>
    </div>
    <header id="header">
      <div class="mui-appbar mui--appbar-line-height">
        <div class="mui-container-fluid">
          <a class="sidedrawer-toggle mui--visible-xs-inline-block mui--visible-sm-inline-block js-show-sidedrawer">☰</a>
          <a class="sidedrawer-toggle mui--hidden-xs mui--hidden-sm js-hide-sidedrawer">☰</a>
          <span class="mui--text-title mui--visible-xs-inline-block mui--visible-sm-inline-block">ToiletFinder</span>
        </div>
      </div>
    </header>
	  <div id="content-wrapper">
	  	<!-- Google Maps canvas -->
<input id="pac-input" class="controls" type="text" placeholder="Search...">
	<div id="map_canvas"></div>  	
	  </div> 
        <div tabindex="0" role="dialog" aria-labelled-by="openModal" aria-haspopup="true" class="modal-dialog dialog" id="openModal">

	<div class="modal">

		<a href="#close" title="Close" class="close push__left no__select bounceInUp" id="close-modal">×</a>
		<div class="inner-dialog">


			<h2>About us</h2>

			<p>Toiletfinder is a web based, mobile friendly application.</p>
			<p>As the name mentioned, toiletfinder offers you the best Convenience to help you find nearst toilet!</p>

			<h2>How to use</h2>
			<p>There are several menu button on the left side, each got their own function, and a place search box inside the map.</p>
			<strong>Locate me</strong><p>Get your current location.(This may need your permission)</p>
			<strong>Find toilet</strong><p>Load already-known toilet data within Melbourne CBD.</p>
			<strong>Add toilet</strong><p>Tell us the toilets that we don't know, and add it to the map.</p>
			<strong>About</strong><p>User guide and other information.</p>
			

		</div> <!-- /inner-dialog -->
<div class="footer-modal footer-push__left no__select">
			<a href="#close" class="" id="footer-close">Get started</a>
		</div>
	</div> <!-- /modal -->
 
</div>
<script>
/*! A poor alternative to :target selector for IE8 and below;
    script can be removed safely if you don't need this support.
*/

'use strict';
var addEvent=function(a,b,d){if(a.addEventListener) a.addEventListener(b,d,false);else if(a.attachEvent) a.attachEvent('on'+b,d);},target=document.getElementById('openModal'),target2=document.getElementById('openModal2'),link1=document.getElementById('link1'),link2=document.getElementById('link2'),link3=document.getElementById('close-modal'),link4=document.getElementById('footer-close'),link5=document.getElementById('close-msg');addEvent(link1,'click',function(){hasClass(target,'visible')?removeClass(target,'visible'):target.className+=' visible'}),addEvent(link2,'click',function(){hasClass(target2,'visible')?removeClass(target2,'visible'):target2.className+=' visible'}),addEvent(link3,'click',function(){restaureClass(target,'modal-dialog dialog')}),addEvent(link4,'click',function(){restaureClass(target,'modal-dialog dialog')}),addEvent(link5,'click',function(){restaureClass(target2,'modal-dialog dialog')});function hasClass(a,b){if('undefined'!=typeof b)return-1<(' '+a.className+' ').indexOf(' '+b+' ')};function restaureClass(a,b){return a.className=b};function addClass(el,className){if (el.classList) el.classList.add(className);else if (!hasClass(el,className)) el.className+=' '+className;}

</script>


<!--add toilet right list -->
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu">
			<h2>Add a Toilet</h2>
			<div>
                <form name="type" action="" method="get">
                    <h4>Type:</h4>
                    <label><input name="toiletType" type="radio" value="" />Indoor </label>
                    <br>
                    <label><input name="toiletType" type="radio" value="" />Outdoor </label>
                </form>  
                <br/>
                <form name="gender" action="" method="get">    
                    <h4>Gender:</h4>
                    <label><input name="toiletGender" type="radio" value="" />Male </label>
                    <br>
                    <label><input name="toiletGender" type="radio" value="" />Female </label>
                    <br>
                    <label><input name="toiletGender" type="radio" value="" />Both </label>
                    <br>
                </form>  
                </br>
                <form name="facilities" action="" method="get">   
                    <h4>Other Facilities:</h4>
                    <label><input name="toiletFacilities" type="checkbox" value="" />Baby </label>
                    <br>
					<label><input name="toiletFacilities" type="checkbox" value="" />Disabilities </label>
               <br>
                </form>
                <br/>    
                <form name="Description" action="" method="get">
                   	<h4>Location Description:</h4>
                    <input name="toiletDescription" type="text" value="" /><br/>
				</form>
                <br>
                
                <!-- add button -->   
                <div class="buttons">
                 <button class="raise">add</button>                      
    			 <button id="closeRight" class="raise">Close</button>
    			 </div>
  </div>
			
		</nav>
        
        <!-- script for add toilet right list-->
        <script src="classie.js"></script>
		<script>
			var menuRight = document.getElementById( 'cbp-spmenu' ),

				showRight = document.getElementById( 'showRight' ),	

				closeRight = document.getElementById( 'closeRight' ),	
				body = document.body;


			closeRight.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				disableOther( 'closeRight' );
				
			};
			showRight.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				disableOther( 'showRight' );
				
			};
			
			function disableOther( button ) {
		
				if( button !== 'showRight' ) {
					classie.toggle( showRight, 'disabled' );
				}
				
			}
			
			function disableOther( close ) {
		
				if( close !== 'closeRight' ) {
					classie.toggle( closeRight, 'disabled' );
				}
				
			}
		</script>
		


 </body>

</html>
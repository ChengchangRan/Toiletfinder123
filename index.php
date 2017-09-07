<?php

?>

<!DOCTYPE html>

<html>

  <header>

    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">

    <meta charset="utf-8">

    <title>Melbourne Toilet Finder</title>
    
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <!-- Use fontawesome-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:300">

	<!-- Google maps API/Google places API-->

	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyABisuaAu1IDWBncs_GHZ5MdLVsfchAVxY&language=en"></script>

	<script src="js/script.js"></script>



  </header>

  <body>
<div class="area">
<!-- Google Maps canvas -->
	<div id="map_canvas"></div>
           </div>
           <nav class="main-menu">
            <ul>
                <li>
                    <a href="index.php">
                        <i class="fa fa-home fa-2x"></i>
                        <span class="nav-text">
                            Home
                        </span>
                    </a>
                  
                </li>
                <li class="has-subnav">
                    <a href="#" onclick="locateMe();" return false;>
                        <i class="fa fa-map-marker fa-2x"></i>
                        <span class="nav-text">
                            Locate me
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="#" onclick="toggleLayer(0);">
                       <i class="fa fa-search fa-2x"></i>
                        <span class="nav-text">
                            Find toilet
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="#">
                       <i class="fa fa-plus-square fa-2x"></i>
                        <span class="nav-text">
                           Add toilet
                        </span>
                    </a>
                   
                </li>   
                <li>
                    <a href="#">
                       <i class="fa fa-info fa-2x"></i>
                        <span class="nav-text">
                            About
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
 </body>

</html>
<?php

?>

<!DOCTYPE html>

<html>

  <header>

    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">

    <meta charset="utf-8">

    <title>Melbourne Toilet Finder</title>
    
    <link href="main.css" rel="stylesheet" type="text/css" />
    <!-- add toilet right list css-->
    <link rel="stylesheet" type="text/css" href="component.css" />
    
    <!-- Use fontawesome-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:300">

	<!-- Google maps API/Google places API-->

	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyABisuaAu1IDWBncs_GHZ5MdLVsfchAVxY&language=en"></script>

	<script src="script.js"></script>
	
	
	<!-- add toilet right list script -->
	<script src="modernizr.custom.js"></script>


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
                        <span class="nav-text" id="showRight">
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
        
        
        <!--add toilet right list -->
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
			<h2>Add a Toilet</h2>
			<div>
                <form name="type" avtion="" method="get">
                    <h4>Type:</h4>
                    <label><input name="toiletType" type="radio" value="" />Indoor </label>
                    <label><input name="toiletType" type="radio" value="" />Outdoor </label>
                </form>  
                <br/>
                <form name="gender" avtion="" method="get">    
                    <h4>Gender:</h4>
                    <label><input name="toiletGender" type="radio" value="" />Male </label>
                    <label><input name="toiletGender" type="radio" value="" />Female </label>
                    <label><input name="toiletGender" type="radio" value="" />Both </label>
                </form>  
                </br>
                <form name="facilities" action="" method="get">   
                    <h4>Other Facilities:</h4>
                    <label><input name="toiletFacilities" type="checkbox" value="" />Baby </label>
					<label><input name="toiletFacilities" type="checkbox" value="" />Disabilities </label>
                </form>
                <br/>    
                <form name="Description" action="" method="get">
                   	<h4>Location Description:</h4>
                    <input name="toiletDescription" type="text" value="" /><br/>
				</form>
                <br>
                
                <!-- add button -->      
                      <input type="submit" on-click="add()" value="Add"/>           
                			
			</div>
		</nav>
        
        <!-- script for add toilet right list-->
        <script src="classie.js"></script>
		<script>
			var menuRight = document.getElementById( 'cbp-spmenu-s2' ),

				showRight = document.getElementById( 'showRight' ),

				body = document.body;


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
		</script>
        
        
 </body>

</html>
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
    
    <link rel="stylesheet" href="css/modal-box.min.css" media="screen">
<link rel="stylesheet" href="css/custom.min.css" media="screen">


	<!-- Google maps API/Google places API-->

	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyABisuaAu1IDWBncs_GHZ5MdLVsfchAVxY&language=en"></script>

	<script src="js/script.js"></script>
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
<div class="area">
<!-- Google Maps canvas -->
<input id="pac-input" class="controls" type="text" placeholder="Search...">
	<div id="map_canvas"></div>      
           </div>
           <nav class="main-menu">
            <ul>
                <li>
                    <a href="index.php" class="button">
                        <i class="fa fa-home fa-2x"></i>
                        <span class="nav-text">
                            Home
                        </span>
                    </a>
                  
                </li>
                <li class="has-subnav">
                    <a href="#" class="button" onclick="locateMe();" return false;>
                        <i class="fa fa-map-marker fa-2x"></i>
                        <span class="nav-text">
                            Locate me
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="#" class="button" onclick="toggleLayer(0);">
                       <i class="fa fa-search fa-2x"></i>
                        <span class="nav-text">
                            Find toilet
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="#" class="button">
                       <i class="fa fa-plus-square fa-2x"></i>
                        <span class="nav-text">
                           Add toilet
                        </span>
                    </a>
                   
                </li>   
                <li>
                    <a href="#openModal" class="button" id="link1">
                       <i class="fa fa-info fa-2x"></i>
                        <span class="nav-text">
                            About
                        </span>
                    </a>
                </li>
            </ul>
            
        </nav>
        <div tabindex="0" role="dialog" aria-labelled-by="openModal" aria-haspopup="true" class="modal-dialog dialog" id="openModal">

	<div class="modal">

		<a href="#close" title="Close" class="close push__left no__select bounceInUp" id="close-modal">×</a>

		<div class="header-modal no__select">
			<h1><strong class="static">©</strong> ToiletFinder</h1> 
		</div>

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
 </body>

</html>
<!DOCTYPE html>

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

<html>

  <header>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="utf-8">

    <title>Melbourne Toilet Finder</title>
    
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <!-- Use fontawesome-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
    <link rel="shortcut icon" type="image/x-icon" href="//www.google.com/images/icons/product/sites-16.ico" />
    <!-- add toilet right list css-->
    <link rel="stylesheet" type="text/css" href="css/component.css" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:300">
    <link href="//cdn.muicss.com/mui-latest/css/mui.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="css/modal-box.min.css" media="screen">
<link rel="stylesheet" href="css/custom.min.css" media="screen">
<script src="//cdn.muicss.com/mui-latest/js/mui.min.js"></script>
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

	<!-- Google maps API/Google places API-->

	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyABisuaAu1IDWBncs_GHZ5MdLVsfchAVxY&language=en"></script>

	<script src="js/script.js"></script>
	<script src="js/sidescript.js"></script>
	
		
	<!-- add toilet right list script -->
	<script src="js/modernizr.custom.js"></script>
	
	
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
          <a href="#" id="showRight"><strong>
                       <i class="fa fa-search fa-2x"></i>
                        <span class="nav-text">
                            Find toilet
			  </span></strong>
                    </a>
        </li>
        <li>
          <a href="#" onclick="adding();"><strong>
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


			<strong>About us</strong>

			<p>Toiletfinder is a web based, mobile friendly application.</p>
			<p>As the name mentioned, toiletfinder offers you the best Convenience to help you find nearst toilet!</p>

			<strong>How to use</strong>
			<p>There are several menu button on the left side, each got their own function, and a place search box inside the map.</p>
			<strong>Locate me</strong><p>Get your current location.(This may need your permission)</p>
			<strong>Find toilet</strong><p>Load already-known toilet data within Melbourne CBD.</p>
			<strong>Show me the path</strong><p>Show you the walking path to the location you choose.</p>
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


<!--find toilet right list -->
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu">
			<h2>Find Toilet</h2>
			<div>
                <form name="type" action="" method="get">
                    <h4>Type:</h4>
                    <label><input name="toiletType" type="checkbox" value=""  onclick="toggleLayer(0);"/>Indoor </label>
                    <br>
                    <label><input name="toiletType" type="checkbox" value=""  onclick="toggleLayer(1);"/>Outdoor </label>
                </form>  
                <br/>
                <form name="facilities" action="" method="get">   
                    <h4>Other Facilities:</h4>
                    <label><input name="toiletFacilities" type="checkbox" value="" onclick="toggleLayer(2);"/>Baby </label>
                    <br>
					<label><input name="toiletFacilities" type="checkbox" value="" onclick="toggleLayer(3);"/>Disabilities </label>
               <br>
                </form>
                <br/>    
                <form name="user-added" action="" method="get">
                    <h4>User-added:</h4>
                    <label><input name="User-added" type="checkbox" value=""  />User-added</label>
                    <br>
                </form>  
                <br>
                
                <!-- close button -->   
               
    			 <button id="closeRight" class="round-button fa fa-times fa-2x"></button>
    			 <button  onclick="window.location.href='index.php'" class="round-button fa fa-refresh fa-2x"></button>
  </div>
			
		</nav>
        
        <!-- script for add toilet right list-->
        <script src="js/classie.js"></script>
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
		
		
			  <div id="map"></div>
	  <div id="addform">
      <table>
      <tr><td>Type:</td> <td><select id='type'> +
                 <option value='outdoor' SELECTED>outdoor</option>
                 <option value='indoor'>indoor</option>
                 </select> </td></tr>
	  <tr><td>Gender:</td> <td><select id='gender'> +
                 <option value='both' SELECTED>both</option>
                 <option value='male'>male</option>
				 <option value='female'>Female</option>
                 </select> </td></tr>
	  <tr><td>Baby Facility:</td> <td><select id='baby'> +
                 <option value='no' SELECTED>no</option>
                 <option value='yes'>yes</option>
                 </select> </td></tr>		
	  <tr><td>Disability Facility:</td> <td><select id='disable'> +
                 <option value='no' SELECTED>no</option>
                 <option value='yes'>yes</option>
                 </select> </td></tr>
	  <tr><td>Description:</td> <td><input type='text' id='description'/> </td> </tr>
	  
                 <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
      </table>
	  </div>
	 	
	 <div id="message">Location saved</div>


 </body>

</html>

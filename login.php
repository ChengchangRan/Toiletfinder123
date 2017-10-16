<?php

	session_start();

	include("php_api_folder/rsa.php");
?>

<html>
<body>

<?php

	if(isset($_POST['username']) == FALSE){
		header('Location: ../client/login.html');
	}

	$received_username = $_POST['username'];
	$received_password = $_POST['password'];

	if($received_username!="" & $received_password != ""){
		$find = 0;

		foreach(file('../database/users.txt') as $line) {
			list($username, $hashed_password) = explode(",",$line);
			if($username == $received_username){
				$find = 1;
		
				$privateKey = get_rsa_privatekey('RSA_keys/private.key');
				$decrypted = rsa_decryption($received_password, $privateKey);
		
				$split_value = explode("&", $decrypted);

				$timestamp = time();
				if($timestamp - (int)$split_value[1] <= 150 ){
					if($hashed_password == $split_value[0]."\n"){
						
						echo "login successful.";
						$_SESSION['user'] = $username;
						$login = 1;
						echo "<br/><br/>Now you can access to the <a href='../client/cart.php'>shopping cart</a><br/>";
					}else{
						echo "Wrong Password.";
					}
				}else{
					echo "<br/><br/>The difference between the client-side submitted timestamp and the current server-side timestamp is greater than 150 seconds. Invalid login request!<br/><br/>";
				}
				break;
			}
		}
		
		if($find==0){
			echo "<br/>Cannot find the username :".$received_username." in the database<br/>";
		}
		
		echo "<br/>Go <a href='http://titan.csit.rmit.edu.au/~s3426887/assignment/'>back</a> to register, login or check the users.txt";
	}else{
		echo "Username and Password cannot be empty!";
		echo "<br/>Go <a href='http://titan.csit.rmit.edu.au/~s3426887/assignment/client'>back</a> to register, login or check the users.txt";
	}
?>


</body>
</html>


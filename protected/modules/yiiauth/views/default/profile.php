<h3>User profile</h3>

<?php
	if( isset( $error ) ){
		echo  $error;
	}

	echo $yiiuser->id. "<br/>";
	echo $yiiuser->username."<br/>";
	echo $provider ."<br/>";
	var_dump($provideruser);
?>
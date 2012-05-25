<?php
	if( isset( $error ) ){
		echo  $error;
	}
	else{
		echo "none";
	}
?>
<h3>User profile</h3>
<?php
	if( isset( $user_profile ) ){
		var_dump( $user_profile );
	}
	else{
		echo "none";
	}
?>
	
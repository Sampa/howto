<?php

class DefaultController extends Controller
{
	public function actionIndex(){
		$this->renderPartial('index');	
	}
	public function actionauthenticatewith( $provider="" ) {   
		require_once( '/hybridauth/Hybrid/Auth.php' );
		$hybridauth_config = $this->hybridAuthConfig();
		$error = false;
		$user_profile = false;
		try{
		// create an instance for Hybridauth with the configuration file path as parameter
			$hybridauth = new Hybrid_Auth( $hybridauth_config );

		// try to authenticate the selected $provider
		if ( isset( $_GET['openid'] ) ){
				$provider = "openid";
				$adapter = $hybridauth->authenticate( $provider,array( "openid_identifier" => $_GET['openid'] ) );
			}else{
				$adapter = $hybridauth->authenticate( $provider );

			}
		// grab the user profile
			$user_profile = $adapter->getUserProfile();
			
		}
		catch( Exception $e ){
			// Display the recived error
			switch( $e->getCode() ){ 
				case 0 : $error = "Unspecified error."; break;
				case 1 : $error = "Hybriauth configuration error."; break;
				case 2 : $error = "Provider not properly configured."; break;
				case 3 : $error = "Unknown or disabled provider."; break;
				case 4 : $error = "Missing provider application credentials."; break;
				case 5 : $error = "Authentification failed. The user has canceled the authentication or the provider refused the connection."; break;
				case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
					     $adapter->logout(); 
					     break;
				case 7 : $error = "User not connected to the provider."; 
					     $adapter->logout(); 
					     break;
			} 

			// well, basically your should not display this to the end user, just give him a hint and move on..
			$error .= "<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
			$error .= "<hr /><pre>Trace:<br />" . $e->getTraceAsString() . "</pre>";  

		}
		/**$user_profile->identifier; //unique id
		$provider; // the provider name
		$_GET['openid'];//the extra_info
		**/
		
		// workOnUser returns an user object
		if ( is_object ($user_profile) ){
		$user = $this->workOnUser($provider,$user_profile->identifier); 
			if ( $this->autoLogin($user) ){
				$this->render('profile',
					array(
					'error'=>$error, 
					'provideruser'=>$user_profile,
					'yiiuser'=>$user,
					'provider'=>$provider,	
					) );
				}else{
					$this->render('authenticatewith',array('error'=>$error,'user_profile'=>$user_profile ) );
					}
			}else{
					echo "Something wrong with ".$provider;
				}
	} 

	public function workOnUser($provider,$provideruser){
		$social = Social::model()->find("provider='".$provider."' AND provideruser='".$provideruser."'");
		if ( $social ){
			 $user = User::model()->find("id=".$social->yiiuser);
			 return $user;
		}else{
			// we want to create a new user, but since we get no user input the validation rules will cause
			//errors on save to counter this i added 'on'=>'validation' to all my user validation rules
			//example: 	array('username, password', 'required','on'=>'validation'),
			// on normal user registration with user input I use: new User('validation') 
			$user = new User;
			$user->username = $provideruser; 
			
			if ( $user->save() ){ //we get an user id
			//add a social connection between the newly created yii user and the provider user account to avoid double regestrations and enable the same yii user to have many providers associated with it.
				$social = new Social;
				$social->yiiuser = $user->id;
				$social->provider = $provider;
				$social->provideruser = $provideruser;
				if($social->save())
					return $user;
			}
		}
	
	}
	
	public function autoLogin($user) //accepts a user object
	{
	$identity=new UserIdentity($user->username, "");
	$identity->hybridauth($user->username);
	if ( $identity->errorCode == UserIdentity::ERROR_NONE )
		{
			$duration= 3600*24*30; // 30 days
			Yii::app()->user->login($identity,$duration);
			return true;
		}
		else
		{
			echo $identity->errorCode;
			return false;
		}
	
	}
}?>
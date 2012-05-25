<?php

class SiteController extends Controller
{


	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}




	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if ( isset ( $_POST['ContactForm'] ) )
		{
			$model->attributes = $_POST['ContactForm'];
			if ( $model->validate() )
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render( 'contact',array( 'model'=>$model ) );
	}

	/**
	 * Displays the login page
	 */
	
/**
* post_tweet.php
* Example of posting a tweet with OAuth
* Latest copy of this code: 
* http://140dev.com/twitter-api-programming-tutorials/hello-twitter-oauth-php/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
*/





	public function actionLogin()
	{	
		$model=new LoginForm;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				  if (Yii::app()->request->isAjaxRequest)
					{			                		
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>'Login',
                        'title'=>'',
                        ));
                    exit;             
					} else{				
						$this->redirect(Yii::app()->user->returnUrl);
						}
				}
		}
		if (Yii::app()->request->isAjaxRequest)
        {
			    $cs=Yii::app()->clientScript;
                $cs->scriptMap=array(
                                                 'jquery.min.js'=>false,
                                                 'jquery.js'=>false,
                                                 'jquery.fancybox-1.3.4.js'=>false,
                                                 'jquery.fancybox.js'=>false,
                                                 'jquery-ui-1.8.12.custom.min.js'=>false,
                                                 'json2.js'=>false,
                                                 'jquery.form.js'=>false,
                                                'form_ajax_binding.js'=>false
								);
            echo CJSON::encode(array(
                'status'=>'render', 
                'div'=>$this->renderPartial('/site/modalLogin', array('model'=>$model), true)));
            exit;               
        } else{
	
		// display the login form
		$this->render('login',array('model'=>$model));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect( Yii::app()->homeUrl."?logout=true" );
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
		$this->render('authenticatewith',array('error'=>$error, 'user_profile'=>$user_profile ) );

	}
	public function actionHauth(){
	$this->render('hauth');
	
	}
	
	public function actionIndex()
	{
		$this->render('pages/index');
	
	}
	

	/**
	 * Restores the database for the demo application.
	 */
	
}
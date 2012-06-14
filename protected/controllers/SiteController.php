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
		$this->performAjaxValidation( $model, 'contact-form' );

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
	
	//search method
	public function actionSearch()
	{	
			
		$this->render( 'search',array(  ) );
			
	}

	/**
	 * Displays the login page
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
		$this->redirect( Yii::app()->homeUrl );
	}
	
	public function actionHauth(){
	$this->render('hauth');
	
	}
	
	public function actionIndex()
	{
		$this->render('pages/index');
	
	}
	
	public function actionQuestion($q)
	{
		$this->renderPartial('questions/'.$q);
	}
	/**
	 * Restores the database for the demo application.
	 */
	
}